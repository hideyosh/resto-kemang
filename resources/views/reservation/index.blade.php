@extends('layouts.app')

@section('title', 'My Reservations')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">My Reservations</h1>

    @if($reservations->isEmpty())
        <p class="text-gray-400">You have no reservations yet.</p>
    @else
        <div class="space-y-4">
            @foreach($reservations as $r)
                <div class="p-4 bg-gray-800 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-400">Reservation {{ $r->user->name }}</div>
                            <div class="text-lg font-bold">{{ $r->reservation_date->format('Y-m-d H:i') }}</div>
                        </div>
                        <a href="/reservations/{{ $r->id }}" class="text-yellow-400 font-semibold">View</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $reservations->links() }}
        </div>
    @endif
</div>
@endsection
