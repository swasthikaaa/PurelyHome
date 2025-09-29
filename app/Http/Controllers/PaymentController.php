<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // ---------------------------
        // ✅ Base validation rules
        // ---------------------------
        $rules = [
            'order_id' => ['required','string'],
            'amount'   => ['required','numeric','min:1'],
            'method'   => ['required','in:card,cod'],
        ];

        if ($request->method === 'cod') {
            $rules = array_merge($rules, [
                'cod_name'    => ['required','string','max:255'],
                'cod_address' => ['required','string','max:255'],
                'cod_city'    => ['required','string','max:255'],
                'cod_state'   => ['required','string','max:255'],
                'cod_zip'     => ['required','digits:5'],
                'cod_phone'   => ['required','regex:/^07\d{8}$/'],
                'cod_notes'   => ['nullable','string','max:500'],
            ]);
        }

        if ($request->method === 'card') {
            $rules = array_merge($rules, [
                'card_address' => ['required','string','max:255'],
                'card_phone'   => ['required','regex:/^07\d{8}$/'],
                'card_number'  => ['required','digits:16'],
                'expiry'       => ['required','regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
                'cvv'          => ['required','digits:3'],
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        // extra expiry validation
        $validator->after(function($validator) use ($request) {
            if ($request->method === 'card' && $request->filled('expiry')) {
                [$m, $y] = explode('/', $request->expiry);
                $month = (int) $m;
                $year  = 2000 + (int) $y;
                $expiryDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
                if ($expiryDate->lt(Carbon::now())) {
                    $validator->errors()->add('expiry', 'Expiry date must be in the future.');
                }
            }
        });

        $validated = $validator->validate();

        // ---------------------------
        // ✅ Attach payment to Order
        // ---------------------------
        $order = Order::findOrFail($validated['order_id']);

        // if payment already exists, update; else create
        $payment = Payment::where('order_id', (string) $order->_id)->first();

        $data = [
            'order_id'       => (string) $order->_id,
            'user_id'        => Auth::id(),
            'amount'         => $validated['amount'],
            'method'         => $validated['method'],
            'status'         => 'paid',
            'transaction_id' => $payment?->transaction_id ?? uniqid('txn_'),
            'address'        => $validated['method'] === 'cod'
                                ? $validated['cod_address']
                                : $validated['card_address'],
            'zip'            => $validated['method'] === 'cod'
                                ? $validated['cod_zip']
                                : null,
            'phone'          => $validated['method'] === 'cod'
                                ? $validated['cod_phone']
                                : $validated['card_phone'],
            'name'           => $validated['method'] === 'cod'
                                ? $validated['cod_name']
                                : null,
            'email'          => Auth::user()->email, // ✅ Always logged-in email
            'city'           => $validated['method'] === 'cod' ? $validated['cod_city'] : null,
            'state'          => $validated['method'] === 'cod' ? $validated['cod_state'] : null,
            'notes'          => $validated['method'] === 'cod' ? ($validated['cod_notes'] ?? null) : null,
        ];

        $payment
            ? $payment->update($data)
            : Payment::create($data);

        // ---------------------------
        // ✅ Redirect to OrderController::success
        // ---------------------------
        return redirect()
            ->route('payment.success', ['order_id' => $order->_id])
            ->with('method', $validated['method']);
    }
}
