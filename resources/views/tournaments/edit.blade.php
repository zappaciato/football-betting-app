@extends('layouts.app')

@section('content')
  <div class="max-w-5xl mx-auto space-y-6 p-4 sm:p-6 lg:p-8">
    <h1 class="text-3xl font-bold text-gray-700">Edit Tournament: {{ $tournament->name }}</h1>

    @if(session('success'))
      <div class="rounded-lg bg-green-100 p-4 text-sm text-green-800">
        {{ session('success') }}
      </div>
    @endif

    {{-- Tournament Edit Form --}}
    <div class="rounded-lg bg-white p-6 shadow">
      <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
          <label class="mb-1 block font-semibold text-gray-700">Tournament Name</label>
          <input type="text" name="name" value="{{ old('name', $tournament->name) }}" required class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
          <label class="mb-1 block font-semibold text-gray-700">Description</label>
          <textarea name="description" rows="2" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $tournament->description) }}</textarea>
        </div>

        <div>
          <label for="start_date" class="mb-1 block font-semibold text-gray-700">Start Date</label>
          <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d') : '') }}" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>

        <div>
          <label for="end_date" class="mb-1 block font-semibold text-gray-700">End Date (Latest Match Date)</label>
          <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $latestMatchDate ? \Carbon\Carbon::parse($latestMatchDate)->format('Y-m-d') : '') }}" class="w-full rounded border border-gray-300 bg-gray-100 px-3 py-2 focus:outline-none" readonly />
          <small class="text-sm text-gray-500">Automatically set to the latest match date in this tournament</small>
        </div>

        <div>
          <button type="submit" class="rounded bg-blue-600 px-6 py-2 text-white transition duration-150 hover:bg-blue-700">Update Tournament</button>
        </div>
      </form>
    </div>

    {{-- Users and Matches Sections --}}
    <div class="grid gap-6 md:grid-cols-2">
      {{-- Users Section --}}
      <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold text-gray-700">Participants</h2>
        @forelse($tournament->users as $user)
          <div class="flex items-center justify-between border-b py-2">
            <span>{{ $user->name }}</span>
            <form action="{{ route('tournaments.users.remove', [$tournament->id, $user->id]) }}" method="POST" onsubmit="return confirm('Remove this user?')">
              @csrf
              @method('DELETE')
              <button class="text-sm text-red-600 hover:underline">Remove</button>
            </form>
          </div>
        @empty
          <p class="text-gray-500">No participants yet.</p>
        @endforelse

        <form action="{{ route('tournaments.users.add', $tournament->id) }}" method="POST" class="mt-4 flex gap-2">
          @csrf
          <select name="user_id" class="flex-grow rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach($allUsers as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
          <button class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">Add</button>
        </form>
      </div>

      {{-- Matches Section --}}
      <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold text-gray-700">Matches</h2>
        @forelse($tournament->matches as $match)
          <div class="flex items-center justify-between border-b py-2">
            <span>{{ $match->home_team }} vs {{ $match->away_team }} ({{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }})</span>
            <form action="{{ route('tournaments.matches.remove', [$tournament->id, $match->id]) }}" method="POST" onsubmit="return confirm('Remove this match?')">
              @csrf
              @method('DELETE')
              <button class="text-sm text-red-600 hover:underline">Remove</button>
            </form>
          </div>
        @empty
          <p class="text-gray-500">No matches yet.</p>
        @endforelse

        <form action="{{ route('tournaments.matches.add', $tournament->id) }}" method="POST" class="mt-4 flex gap-2">
          @csrf
          <select name="match_id" class="flex-grow rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach($allMatches as $match)
              <option value="{{ $match->id }}">{{ $match->home_team }} vs {{ $match->away_team }} ({{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }})</option>
            @endforeach
          </select>
          <button class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">Add</button>
        </form>
      </div>
    </div>
  </div>
@endsection
