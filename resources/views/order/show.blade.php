@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Order #{{ $order->id }}</h1>

    <div class="bg-gray-800 p-6 rounded-lg">
        <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p class="mt-4"><strong>Items:</strong></p>
        <ul class="list-disc list-inside">
            @foreach($order->orderItems as $item)
                <li>{{ $item->menuItem->name }} &times; {{ $item->quantity }} — Rp {{ number_format($item->price, 0, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
