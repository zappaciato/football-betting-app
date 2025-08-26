@extends('layouts.app')

@section('content')
<div class="tournaments-container">

    {{-- Header --}}
    <div class="tournaments-header">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">Tournaments</h1>
                @if(auth()->user()->id === 1) <!-- Admin -->
            <x-responsive-nav-link class="k001-button-add" :href="route('tournaments.create')">
                {{ __('Create a Tournament') }}
            </x-responsive-nav-link>

        @else
        <!-- What a user will see in the matches list - NOT ADMIN .. indexUser and Idex reapat a lot of coude FIX it-->
        @endif
    </div>
        </div>

    {{-- Empty State --}}
    @if($tournaments->isEmpty())
        <p class="tournaments-empty">No tournaments to display.</p>
    @else
        {{-- Tournament Grid --}}
        <div class="tournaments-grid">
            @foreach($tournaments as $tournament)
                @php
                    $isActive = $tournament->matches()
                        ->whereNull('result_home')
                        ->orWhereNull('result_away')
                        ->orWhere('result_home', '')
                        ->orWhere('result_away', '')
                        ->exists();
                @endphp

                <div class="tournament-card">
                    <img src="https://source.unsplash.com/400x200/?tournament,sports" alt="{{ $tournament->name }}">
                    <div class="tournament-card-body">
                        <div class="tournament-card-header">
                            <h2 class="tournament-card-title">{{ $tournament->name }}</h2>
                            <span class="tournament-status {{ $isActive ? 'tournament-status-active' : 'tournament-status-completed' }}">
                                {{ $isActive ? 'Active' : 'Completed' }}
                            </span>
                        </div>

                        <div class="tournament-dates">
                            <p><span>Created:</span> {{ $tournament->created_at->format('M d, Y') }}</p>
                            @if($tournament->start_date)
                                <p><span>Start:</span> {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}</p>
                            @endif
                            @if($tournament->end_date)
                                <p><span>End:</span> {{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}</p>
                            @endif
                        </div>

                        <div class="tournament-actions">
                            <a href="{{ route('tournaments.tournamentUser', $tournament->id) }}" class="view">View</a>
                            @if(auth()->user()->id === 1)
                                <a href="{{ route('tournaments.edit', $tournament->id) }}" class="edit">Edit</a>
                            @endif
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @endif

</div>
@endsection
