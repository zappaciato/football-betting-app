@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $tournament->name }}</h1>
    @if($tournament->description)
        <p class="mb-4">{{ $tournament->description }}</p>
    @endif
    
    @include('components.score_table', ['scores' => $scores])
    <ul class="space-y-2">
        @foreach($tournament->matches as $match)
            @php
                // Fetch the current user's prediction (if loaded)
                $prediction = $match->predictions->first();
            @endphp
            <li>
                {{ $match->home_team }} vs {{ $match->away_team }}
                ({{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }})

                        @if($prediction)
                    — Your prediction: {{ $prediction->predicted_home }} : {{ $prediction->predicted_away }}
                @else
                    — <em>No prediction yet</em>
                @endif
            </li>
        @endforeach

</ul>
</div>
@endsection
