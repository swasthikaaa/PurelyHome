<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->_id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 20px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .total td { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Invoice #{{ $order->_id }}</h1>
    <p><strong>Date:</strong> {{ $order->order_date->format('d M Y, h:i A') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }} ({{ $order->user->email ?? '' }})</p>

    <h3>Products</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price (Rs)</th>
                <th>Total (Rs)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Unknown' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->price * $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Billing</h3>
    <table>
        <tr>
            <td>Subtotal</td>
            <td>Rs {{ $subtotal }}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td>Rs {{ $shipping }}</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td>Rs {{ $tax }}</td>
        </tr>
        <tr class="total">
            <td>Total</td>
            <td>Rs {{ $total }}</td>
        </tr>
    </table>

    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment->method ?? 'N/A') }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment->status ?? 'pending') }}</p>
</body>
</html>
