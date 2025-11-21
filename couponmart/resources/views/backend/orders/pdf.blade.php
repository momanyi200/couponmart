<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .qr { text-align: center; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #444; }
        th, td { padding: 8px; font-size: 14px; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <h2>Order Summary</h2>
        <p>Order No: <strong>{{ $order->order_number }}</strong></p>
        <p>Total: <strong>KSh {{ number_format($order->total, 2) }}</strong></p>
    </div>

    <div class="qr">
        <img src="{{ public_path($order->qr_code_path) }}" width="200">
    </div>

    <h3>Items</h3>
    <table>
        <thead>
        <tr>
            <th>Coupon</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->coupon->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>KSh {{ number_format($item->price, 2) }}</td>
                <td>KSh {{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

</body>
</html>
