@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h1 class="text-2xl font-bold mb-6">Create New Tournament</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tournaments.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-gray-700 font-semibold mb-1">Tournament Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-gray-700 font-semibold mb-1">Description</label>
            <textarea name="description" id="description" rows="3"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <!-- Start Date -->
        <div>
            <label for="start_date" class="block text-gray-700 font-semibold mb-1">Start Date <span class="text-red-500">*</span></label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- End Date -->
        <div>
            <label for="end_date" class="block text-gray-700 font-semibold mb-1">End Date <span class="text-red-500">*</span></label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Users (Participants) -->
        <div>
            <label for="users" class="block text-gray-700 font-semibold mb-1">Participants <span class="text-red-500">*</span></label>
            <select name="users[]" id="users" multiple required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 h-32">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (collect(old('users'))->contains($user->id)) ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Hold Ctrl (Cmd on Mac) to select multiple users.</p>
        </div>

        <!-- Matches -->
        <div>
            <label for="matches" class="block text-gray-700 font-semibold mb-1">Matches <span class="text-red-500">*</span></label>
            <select name="matches[]" id="matches" multiple required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 h-32">
                @foreach($matches as $match)
                    <option value="{{ $match->id }}" {{ (collect(old('matches'))->contains($match->id)) ? 'selected' : '' }}>
                        {{ $match->home_team }} vs {{ $match->away_team }} - {{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Hold Ctrl (Cmd on Mac) to select multiple matches.</p>
        </div>

        <div>
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-150">
                Create Tournament
            </button>
        </div>
    </form>
</div>
@endsection
