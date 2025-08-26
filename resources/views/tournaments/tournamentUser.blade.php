@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $tournament->name }}</h1>
    @if($tournament->description)
        <p class="mb-4">{{ $tournament->description }}</p>
    @endif
    <ul class="space-y-2">
        @foreach($tournament->matches as $match)
            <li>{{ $match->home_team }} vs {{ $match->away_team }} ({{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }})</li>
        @endforeach
    </ul>
</div>
@endsection
