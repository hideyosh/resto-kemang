@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">My Orders</h1>

    @if($orders->isEmpty())
        <p class="text-gray-400">You have no orders yet.</p>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-400">Order #{{ $order->id }}</div>
                            <div class="text-lg font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </div>
                        <a href="/orders/{{ $order->id }}" class="text-yellow-400 font-semibold">View</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
