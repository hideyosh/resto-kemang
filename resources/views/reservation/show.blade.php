@extends('layouts.app')

@section('title', 'Reservation Detail')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Reservation #{{ $reservation->id }}</h1>

    <div class="bg-gray-800 p-6 rounded-lg">
        <p><strong>Date:</strong> {{ $reservation->reservation_date->format('Y-m-d H:i') }}</p>
        <p><strong>Guests:</strong> {{ $reservation->number_of_guests }}</p>
        <p><strong>Status:</strong> {{ ucfirst($reservation->status) }}</p>
        @if($reservation->notes)
            <p class="mt-4"><strong>Notes:</strong> {{ $reservation->notes }}</p>
        @endif
    </div>
</div>
@endsection
