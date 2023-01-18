<x-mail::message>
# Hello {{ $order->user->name }}

Your order status is {{ $order->status }}.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
