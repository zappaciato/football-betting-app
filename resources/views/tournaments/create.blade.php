@extends('layouts.app')

@section('content')
  <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="rounded-lg bg-white p-6 shadow">
      <h1 class="mb-6 text-3xl font-bold text-gray-700">Create New Tournament</h1>

      @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-800">
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
          <label for="name" class="mb-1 block font-semibold text-gray-700">Tournament Name <span class="text-red-500">*</span></label>
          <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="mb-1 block font-semibold text-gray-700">Description</label>
          <textarea name="description" id="description" rows="3" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <!-- Start Date -->
        <div>
          <label for="start_date" class="mb-1 block font-semibold text-gray-700">Start Date <span class="text-red-500">*</span></label>
          <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- End Date -->
        <div>
          <label for="end_date" class="mb-1 block font-semibold text-gray-700">End Date <span class="text-red-500">*</span></label>
          <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Users (Participants) -->
        <div>
          <label for="users" class="mb-1 block font-semibold text-gray-700">Participants <span class="text-red-500">*</span></label>
          <select name="users[]" id="users" multiple required class="h-32 w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ (collect(old('users'))->contains($user->id)) ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
            @endforeach
          </select>
          <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple users.</p>
        </div>

        <!-- Matches -->
        <div>
          <label for="matches" class="mb-1 block font-semibold text-gray-700">Matches <span class="text-red-500">*</span></label>
          <select name="matches[]" id="matches" multiple required class="h-32 w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach($matches as $match)
              <option value="{{ $match->id }}" {{ (collect(old('matches'))->contains($match->id)) ? 'selected' : '' }}>
                {{ $match->home_team }} vs {{ $match->away_team }} - {{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }}
              </option>
            @endforeach
          </select>
          <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple matches.</p>
        </div>

        <div>
          <button type="submit" class="rounded bg-blue-600 px-6 py-2 text-white transition duration-150 hover:bg-blue-700">
            Create Tournament
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
