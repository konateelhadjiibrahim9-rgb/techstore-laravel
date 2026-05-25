<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initialize payment with CinetPay
     */
    public function initiatePayment(Request $request, $orderId)
    {
        $order = Order::where('order_number', $orderId)->firstOrFail();
        
        // CinetPay API Configuration
        $apiKey = config('services.cinetpay.api_key');
        $siteId = config('services.cinetpay.site_id');
        
        // Payment parameters
        $amount = $order->total_amount;
        $currency = 'XOF'; // Franc CFA de l'Afrique de l'Ouest
        $transactionId = $order->order_number;
        $description = "Commande #{$order->order_number}";
        $returnUrl = route('payment.callback');
        $notifyUrl = route('payment.notify');
        
        // Customer information
        $customerName = auth()->user()->name;
        $customerEmail = auth()->user()->email;
        $customerPhone = $order->shipping_phone;
        
        try {
            // Prepare payment request
            $paymentData = [
                'apikey' => $apiKey,
                'site_id' => $siteId,
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
                'return_url' => $returnUrl,
                'notify_url' => $notifyUrl,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'metadata' => json_encode([
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ]),
            ];
            
            // Make API request to CinetPay
            $response = $this->makeCinetPayRequest($paymentData);
            
            if ($response['status'] == 'success') {
                return redirect()->away($response['payment_url']);
            } else {
                return back()->with('error', 'Erreur lors de l\'initialisation du paiement: ' . $response['message']);
            }
            
        } catch (\Exception $e) {
            Log::error('Payment initialization error: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'initialisation du paiement.');
        }
    }
    
    /**
     * Handle payment callback from CinetPay
     */
    public function handleCallback(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');
        
        $order = Order::where('order_number', $transactionId)->firstOrFail();
        
        if ($status == 'success' || $status == 'ACCEPTED') {
            $order->status = 'paid';
            $order->save();
            
            return redirect()->route('order.confirmation', ['order' => $order->order_number])
                ->with('success', 'Paiement réussi !');
        } else {
            $order->status = 'cancelled';
            $order->save();
            
            return redirect()->route('cart')->with('error', 'Paiement échoué ou annulé.');
        }
    }
    
    /**
     * Handle payment notification from CinetPay (webhook)
     */
    public function handleNotification(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');
        
        $order = Order::where('order_number', $transactionId)->first();
        
        if ($order) {
            if ($status == 'success' || $status == 'ACCEPTED') {
                $order->status = 'paid';
            } else {
                $order->status = 'cancelled';
            }
            $order->save();
        }
        
        return response()->json(['status' => 'success']);
    }
    
    /**
     * Make API request to CinetPay
     */
    private function makeCinetPayRequest($data)
    {
        $url = 'https://api.cinetpay.com/v1/?method=generic.payment.init';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $responseData = json_decode($response, true);
        
        if ($httpCode == 200 && isset($responseData['code']) && $responseData['code'] == 201) {
            return [
                'status' => 'success',
                'payment_url' => $responseData['data']['payment_url'],
            ];
        }
        
        return [
            'status' => 'error',
            'message' => $responseData['message'] ?? 'Erreur inconnue',
        ];
    }
    
    /**
     * Check payment status
     */
    public function checkPaymentStatus($orderId)
    {
        $order = Order::where('order_number', $orderId)->firstOrFail();
        
        return response()->json([
            'order_number' => $order->order_number,
            'status' => $order->status,
            'total_amount' => $order->total_amount,
        ]);
    }
}
