@extends('layouts.app')

@section('content')
  @if (session('warning'))
    <div class="max-w-5xl mx-auto p-4">
      <div class="mb-4 rounded-lg bg-yellow-100 p-4 text-sm text-yellow-800">
        {{ session('warning') }}
      </div>
    </div>
  @endif

  <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <h1 class="text-3xl font-bold text-gray-700">Tournaments</h1>

      @if(auth()->user()->id === 1)
        <x-responsive-nav-link class="k001-button-add" :href="route('tournaments.create')">
          {{ __('Create a Tournament') }}
        </x-responsive-nav-link>
      @endif
    </div>

    @if($tournaments->isEmpty())
      <div class="rounded-lg bg-white p-6 text-center shadow">
        <h3 class="mb-2 text-lg font-semibold text-gray-700">No tournaments</h3>
        <p class="mb-4 text-gray-500">No tournaments to display.</p>
      </div>
    @else
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($tournaments as $tournament)
          @php
            $isActive = $tournament->matches()
                ->whereNull('result_home')
                ->orWhereNull('result_away')
                ->orWhere('result_home', '')
                ->orWhere('result_away', '')
                ->exists();
          @endphp

          <div class="overflow-hidden rounded-lg bg-white shadow transition hover:shadow-md">
            <img
              src="https://source.unsplash.com/400x200/?tournament,sports"
              alt="{{ $tournament->name }}"
              class="h-40 w-full object-cover"
            />
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-700">{{ $tournament->name }}</h2>
                <span class="text-sm font-semibold {{ $isActive ? 'text-green-600' : 'text-gray-500' }}">
                  {{ $isActive ? 'Active' : 'Completed' }}
                </span>
              </div>

              <div class="mb-4 text-sm text-gray-500">
                <p><span class="font-medium text-gray-700">Created:</span> {{ $tournament->created_at->format('M d, Y') }}</p>
                @if($tournament->start_date)
                  <p><span class="font-medium text-gray-700">Start:</span> {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}</p>
                @endif
                @if($tournament->end_date)
                  <p><span class="font-medium text-gray-700">End:</span> {{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}</p>
                @endif
              </div>

              <div class="flex justify-between text-sm">
                <a href="{{ route('tournaments.tournamentUser', $tournament->id) }}" class="text-blue-600 hover:underline">View</a>
                @if(auth()->user()->id === 1)
                  <a href="{{ route('tournaments.edit', $tournament->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
