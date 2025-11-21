<h2>Hello {{ $order->user->name }},</h2>

<p>Your order <strong>{{ $order->order_number }}</strong> has been successfully redeemed on 
{{ $order->redeemed_at?->format('d M Y H:i') ?? 'N/A' }}.
</p>

<p>Order Details:</p>
<ul>
    @foreach($order->items as $item)
        <li>{{ $item->coupon->title }} × {{ $item->quantity }} (KSh {{ number_format($item->price * $item->quantity, 2) }})</li>
    @endforeach
</ul>

<p>Total: <strong>KSh {{ number_format($order->total, 2) }}</strong></p>

<p>Thank you for using our service!</p>
