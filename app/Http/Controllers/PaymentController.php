<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        $payments = Payment::with('order')->get();
        return PaymentResource::collection($payments);
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'        => 'required|exists:orders,id',
            'amount'          => 'required|numeric|min:0',
            'method'          => 'required|string|max:255',
            'status'          => 'required|string|max:255',
            'transaction_ref' => 'nullable|string|max:255',
        ]);

        $payment = Payment::create($validated);

        return new PaymentResource($payment);
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        return new PaymentResource($payment->load('order'));
    }

    /**
     * Update the specified payment.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id'        => 'sometimes|exists:orders,id',
            'amount'          => 'sometimes|numeric|min:0',
            'method'          => 'sometimes|string|max:255',
            'status'          => 'sometimes|string|max:255',
            'transaction_ref' => 'nullable|string|max:255',
        ]);

        $payment->update($validated);

        return new PaymentResource($payment);
    }

    /**
     * Remove the specified payment.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully.']);
    }
}
