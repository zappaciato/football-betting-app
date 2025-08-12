@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Tournament: {{ $tournament->name }}</h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    {{-- Tournament Details Form --}}
    <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-semibold mb-1">Tournament Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $tournament->name) }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('name')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="start_date" class="block font-semibold mb-1">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d') : '') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('start_date')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="end_date" class="block font-semibold mb-1">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('start_date', $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d') : '') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('end_date')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="description" class="block font-semibold mb-1">Description</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $tournament->description) }}</textarea>
            @error('description')<p class="text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-5 py-2 rounded-md hover:bg-indigo-700 transition">Update Tournament</button>
    </form>

    {{-- Matches Section --}}
    <section class="mt-12 bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Matches in this Tournament</h2>

        @if($tournament->matches->isEmpty())
            <p class="text-gray-600 mb-4">No matches added to this tournament yet.</p>
        @else
            <ul class="divide-y divide-gray-200 mb-6">
                @foreach($tournament->matches as $match)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <strong>{{ $match->home_team }}</strong> vs <strong>{{ $match->away_team }}</strong>
                            <span class="text-gray-500 ml-2">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y H:i') }}</span>
                        </div>
                        <form action="{{ route('tournaments.matches.remove', [$tournament->id, $match->id]) }}" method="POST" onsubmit="return confirm('Remove this match?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Add Match --}}
        <form action="{{ route('tournaments.matches.add', $tournament->id) }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <label for="match_id" class="font-semibold">Add Match:</label>
            <select id="match_id" name="match_id" required class="border rounded px-3 py-2 w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Select a Match --</option>
                @foreach($allMatches as $match)
                    @if(!$tournament->matches->contains($match))
                    <option value="{{ $match->id }}">
                        {{ $match->home_team }} vs {{ $match->away_team }} ({{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }})
                    </option>
                    @endif
                @endforeach
            </select>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Add</button>
        </form>
    </section>

    {{-- Users Section --}}
    <section class="mt-12 bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Users in this Tournament</h2>

        @if($tournament->users->isEmpty())
            <p class="text-gray-600 mb-4">No users added to this tournament yet.</p>
        @else
            <ul class="divide-y divide-gray-200 mb-6">
                @foreach($tournament->users as $user)
                    <li class="py-3 flex justify-between items-center">
                        <div>{{ $user->name }}</div>
                        <form action="{{ route('tournaments.users.remove', [$tournament->id, $user->id]) }}" method="POST" onsubmit="return confirm('Remove this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Add User --}}
        <form action="{{ route('tournaments.users.add', $tournament->id) }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <label for="user_id" class="font-semibold">Add User:</label>
            <select id="user_id" name="user_id" required class="border rounded px-3 py-2 w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Select a User --</option>
                @foreach($allUsers as $user)
                    @if(!$tournament->users->contains($user))
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Add</button>
        </form>
    </section>
</div>
@endsection
