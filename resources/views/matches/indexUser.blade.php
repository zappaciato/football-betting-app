@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Matches</h1>
        
        @if(auth()->user()->id === 1) <!-- Admin -->
<x-responsive-nav-link class="k001-button-add" :href="route('matches.create')">
    {{ __('Add a MATCH') }}
</x-responsive-nav-link>

        @else
        <!-- What a user will see in the matches list - NOT ADMIN -->
        @endif
    </div>

    @if($matches->count() > 0)
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Date</th>
                    <th class="border border-gray-300 px-4 py-2">Home Team</th>
                    <th class="border border-gray-300 px-4 py-2">Result Home</th>
                    <th class="border border-gray-300 px-4 py-2">Result Away</th>
                    <th class="border border-gray-300 px-4 py-2">Away Team</th>

                    <th class="border border-gray-300 px-4 py-2">Score</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matches as $match)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y H:i') }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">  {{ $match->home_team }}</td>
                    <td class="border border-gray-300 px-4 py-2">  {{ $match->result_home }}</td>
                    <td class="border border-gray-300 px-4 py-2">  {{ $match->result_away }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $match->away_team }}</td>

                    <td class="border border-gray-300 px-4 py-2">
                        @if($match->result_home !== null && $match->result_away !== null)
                           <span style="font-size: 0.6rem; color: #1E40AF">{{$match->home_team}} </span> {{ $match->result_home }} - <span style="font-size: 0.6rem; color: #DC2626">{{$match->away_team}} </span> {{ $match->result_away }}
                        @else
                            Not scored yet
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        @if(auth()->user()->id === 1) <!-- Admin -->
                            <a href="{{ route('matches.editScore', $match->id) }}" class="text-indigo-600 hover:underline">Update Score</a>
                        @else <!-- Regular user -->
                            <a href="" class="text-green-600 hover:underline">Predict Score</a>
                        @endif         
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


    @else
        <p>No matches found.</p>
    @endif
</div>
@endsection
