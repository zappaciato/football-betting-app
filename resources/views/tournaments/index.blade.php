@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Tournaments</h1>
        <a href="{{ route('tournaments.create') }}">Create a new tournament!</a>
        <a href="{{ url()->current() }}?show={{ $showAll ? 'active' : 'all' }}"
           class="px-4 py-2 rounded-md text-sm font-semibold
                  {{ $showAll ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            {{ $showAll ? 'Show Active Only' : 'Show All' }}
        </a>
    </div>

    @if($tournaments->isEmpty())
        <p class="text-center text-gray-600 mt-16">No tournaments to display.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tournaments as $tournament)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-indigo-900">{{ $tournament->name }}</h2>
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $tournament->matches()->whereNull('result_home')
                                ->orWhereNull('result_away')
                                ->orWhere('result_home', '')
                                ->orWhere('result_away', '')
                                ->exists() ? 'bg-green-100 text-green-800' : 'bg-gray-300 text-gray-600' }}">
                            {{ $tournament->matches()->whereNull('result_home')
                                ->orWhereNull('result_away')
                                ->orWhere('result_home', '')
                                ->orWhere('result_away', '')
                                ->exists() ? 'Active' : 'Completed' }}
                        </span>
                    </div>

                    <p class="mt-2 text-gray-700">
                        Created: {{ $tournament->created_at->format('M d, Y') }}<br>
                        @if($tournament->start_date)
                        Start: {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}<br>
                        @endif
                        @if($tournament->end_date)
                        End: {{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}
                        @endif
                    </p>

                    <div class="mt-4 flex space-x-3">
                        <a href="{{ route('tournaments.show', $tournament->id) }}"
                           class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700">
                            View
                        </a>

                        <a href="{{ route('tournaments.edit', $tournament->id) }}"
                           class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-300">
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
