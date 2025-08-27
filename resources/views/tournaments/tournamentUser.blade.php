@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 text-white">
            <h1 class="text-3xl font-bold">{{ $tournament->name }}</h1>
            <p class="mt-1 text-sm text-indigo-100">
                {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}
                —
                {{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}
            </p>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">

            <!-- Description -->
            @if($tournament->description)
                <p class="text-gray-900">{{ $tournament->description }}</p>
            @else
                <p class="italic text-gray-600">No description provided.</p>
            @endif

            @include('components.score_table', ['scores' => $scores])

            <!-- Matches -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Matches</h2>
                @if($tournament->matches->count())
                    <ul class="divide-y divide-gray-200">
                        @foreach($tournament->matches as $match)
                            @php
                                $prediction = $match->predictions->first();

                            @endphp

                            <?php echo ($match->result_home === $prediction->predicted_home && $match->result_away === $prediction->predicted_away ) ? '<li class="text-sm text-red-600"> <p>Well done mate!</p>' : '<li class="text-sm text-grey-800">'; ?>

                              <div>
                                    <span class="font-semibold">{{ $match->home_team }}</span>
                                    <span class="font-semibold">{{ $match->result_home }}</span>
                                    vs
                                    <span class="font-semibold">{{ $match->away_team }}</span>
                                    <span class="font-semibold">{{ $match->result_away }}</span>
                                    <span class="text-gray-500 ml-2">
                                        {{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}
                                    </span>
                                </div>
                                <div class="text-gray-600">
                                    @if($prediction)
                                        Your prediction: {{ $prediction->predicted_home }} : {{ $prediction->predicted_away }}
                                    @else
                                        <em>No prediction yet</em>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">No matches scheduled yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
