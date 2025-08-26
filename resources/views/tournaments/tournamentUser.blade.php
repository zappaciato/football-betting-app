@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $tournament->name }}</h1>
    @if($tournament->description)
        <p class="mb-4">{{ $tournament->description }}</p>
    @endif
    <ul class="space-y-2">
        @foreach($tournament->matches as $match)
            @php
        // ponieważ dociągnęliśmy TYLKO predykcje tego usera, bierzemy pierwszą (albo null)
        $pred = $match->predictions->first();
            @endphp
<li>
        {{ $match->home_team }} vs {{ $match->away_team }}
        ({{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }})

        @if($pred)
            — Your prediction: {{ $pred->predicted_home }} : {{ $pred->predicted_away }}
        @else
            — <em>No prediction yet</em>
        @endif
    </li>
@endforeach
</ul>
</div>
@endsection
