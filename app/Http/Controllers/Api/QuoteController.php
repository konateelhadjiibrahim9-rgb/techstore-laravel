<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::with('productCategory')->where('user_id', auth()->id());

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $perPage = $request->has('per_page') ? (int) $request->per_page : 15;
        $quotes = $query->paginate($perPage);

        return QuoteResource::collection($quotes);
    }

    public function show($id)
    {
        $quote = Quote::with('productCategory')->where('user_id', auth()->id())->findOrFail($id);

        return new QuoteResource($quote);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'data' => 'required|array',
            'message' => 'nullable|string',
        ]);

        $quote = Quote::create([
            'user_id' => auth()->id(),
            'reference' => 'QT-' . date('Y') . '-' . str_pad(Quote::count() + 1, 3, '0', STR_PAD_LEFT),
            'product_category_id' => $validated['product_category_id'],
            'data' => $validated['data'],
            'status' => 'pending',
        ]);

        return new QuoteResource($quote->load('productCategory'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $quote = Quote::where('user_id', auth()->id())->findOrFail($id);
        $quote->status = $validated['status'];
        
        if ($validated['status'] === 'approved') {
            $quote->processed_at = now();
        } elseif ($validated['status'] === 'rejected') {
            $quote->completed_at = now();
        }
        
        $quote->save();

        return new QuoteResource($quote);
    }
}
