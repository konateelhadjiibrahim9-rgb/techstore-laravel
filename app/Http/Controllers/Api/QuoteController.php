<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'message' => 'required|string',
            'estimated_amount' => 'nullable|numeric|min:0',
        ]);

        $quote = Quote::create([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'company_name' => $validated['company_name'] ?? null,
            'message' => $validated['message'],
            'estimated_amount' => $validated['estimated_amount'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Quote created successfully',
            'quote' => $quote,
        ], 201);
    }
}
