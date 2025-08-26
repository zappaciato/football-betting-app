@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Create Predictions for {{ $tournament->name }}</h1>
    <form method="POST" action="#">
        @csrf
        <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
        @foreach($matches as $match)
            <div class="mb-4">
                <p class="mb-2">{{ $match->home_team }} vs {{ $match->away_team }} ({{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }})</p>
                <div class="flex space-x-2">
                    <input type="number" name="predictions[{{ $match->id }}][home]" class="border rounded p-1 w-16" placeholder="Home">
                    <span>-</span>
                    <input type="number" name="predictions[{{ $match->id }}][away]" class="border rounded p-1 w-16" placeholder="Away">
                </div>
            </div>
        @endforeach
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save Predictions</button>
    </form>
</div>
@endsection
