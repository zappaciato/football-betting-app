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

            <!-- Users -->
            <div>
                <h2 class="text-lg font-semibold text-indigo-700 mb-3">👥 Participants</h2>
                @if($tournament->users->count())
                    <ul class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($tournament->users as $user)
                            <li class="bg-indigo-50 border border-indigo-200 rounded-md px-3 py-2 text-sm text-indigo-900 font-medium">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-700 text-sm">No users assigned yet.</p>
                @endif
            </div>

            @include('components.score_table', ['scores' => $scores])

            <!-- Matches -->
<div>
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Matches</h2>
    @if($tournament->matches->count())
        <ul class="divide-y divide-gray-200">
            @foreach($tournament->matches as $match)
                <li class="py-2 flex justify-between items-center text-sm text-gray-800">
                    <div class="flex space-x-6">
                        <span class="font-semibold">{{ $match->home_team }}</span>
                        <span class="font-semibold">{{ $match->away_team }}</span>
                        <span class="text-gray-500">
                            {{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}
                        </span>
                        <span>
                            {{ isset($match->score_home) ? $match->result_home : '-' }}
                        </span>
                        <span>
                            {{ isset($match->score_away) ? $match->result_away : '-' }}
                        </span>
                    </div>

            @endforeach
        </ul>
    @else
        <p class="text-gray-500 text-sm">No matches scheduled yet.</p>
    @endif
</div>


        <!-- Footer -->
<div class="flex justify-between items-center border-t p-6 bg-gray-100">
    <a href="{{ route('tournaments.edit', $tournament->id) }}"
       class="inline-block bg-gray-300 text-black font-semibold px-5 py-2 rounded-lg shadow hover:bg-gray-400 focus:ring-2 focus:ring-gray-500 transition">
        ✏️ Edit
    </a>

    <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this tournament?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="bg-gray-300 text-black font-semibold px-5 py-2 rounded-lg shadow hover:bg-gray-400 focus:ring-2 focus:ring-gray-500 transition">
            🗑 Delete
        </button>
    </form>
</div>
    </div>
</div>
@endsection
