@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
    <h1 class="text-2xl font-bold mb-6">Add New Match</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('matches.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Tournament ID</label>
            <input type="number" name="tournament_id" value="{{ old('tournament_id') }}"
                   class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block font-medium">Home Team</label>
            <input type="text" name="home_team" value="{{ old('team_home') }}"
                   class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block font-medium">Away Team</label>
            <input type="text" name="away_team" value="{{ old('team_away') }}"
                   class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block font-medium">Match Date</label>
            <input type="datetime-local" name="match_date" value="{{ old('match_date') }}"
                   class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
            Save Match
        </button>
    </form>
</div>
@endsection
