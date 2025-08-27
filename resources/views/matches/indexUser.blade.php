@extends('layouts.app')

@section('content')

  {{-- Flash redirectów --}}
  @if (session('warning'))
    <div class="max-w-5xl mx-auto p-4">
      <div class="mb-4 rounded-lg bg-yellow-100 p-4 text-sm text-yellow-800">
        {{ session('warning') }}
      </div>
    </div>
  @endif

  <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <h1 class="text-3xl font-bold text-gray-700">Matches</h1>

      @if(auth()->user()->id === 1)
        <x-responsive-nav-link class="k001-button-add" :href="route('matches.create')">
          {{ __('Add a MATCH') }}
        </x-responsive-nav-link>
      @endif
    </div>

    @if ($matches->isEmpty())
      <div class="rounded-lg bg-white p-6 text-center shadow">
        <h3 class="mb-2 text-lg font-semibold text-gray-700">{{ $emptyTitle ?? 'Brak danych' }}</h3>
        <p class="mb-4 text-gray-500">{{ $emptyText ?? 'No Matches found!' }}</p>
        @isset($emptyCtaUrl)
          <a href="{{ $emptyCtaUrl }}" class="inline-block rounded bg-blue-200 px-4 py-2 text-sm text-blue-800 hover:bg-blue-300">{{ $emptyCtaTxt ?? 'OK' }}</a>
        @endisset
      </div>
    @else
      <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm text-gray-600">
          <thead class="bg-blue-50 text-gray-700">
            <tr>
              <th scope="col" class="px-4 py-3">Date</th>
              <th scope="col" class="px-4 py-3">Home Team</th>
              <th scope="col" class="px-4 py-3">Result Home</th>
              <th scope="col" class="px-4 py-3">Result Away</th>
              <th scope="col" class="px-4 py-3">Away Team</th>
              <th scope="col" class="px-4 py-3">Score</th>
              <th scope="col" class="px-4 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @foreach($matches as $match)
              <tr class="hover:bg-blue-50">
                <td class="whitespace-nowrap px-4 py-2">{{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y H:i') }}</td>
                <td class="px-4 py-2">{{ $match->home_team }}</td>
                <td class="px-4 py-2">{{ $match->result_home }}</td>
                <td class="px-4 py-2">{{ $match->result_away }}</td>
                <td class="px-4 py-2">{{ $match->away_team }}</td>
                <td class="px-4 py-2 text-center">
                  @if(is_null($match->result_home) || is_null($match->result_away))
                    <span class="text-gray-400">Not scored yet</span>
                  @else
                    <span class="text-blue-700">{{ $match->home_team }}</span>
                    {{ $match->result_home }} -
                    <span class="text-red-600">{{ $match->away_team }}</span>
                    {{ $match->result_away }}
                  @endif
                </td>
                <td class="px-4 py-2 text-center">
                  @if(auth()->user()->id === 1)
                    <a href="{{ route('matches.editScore', $match->id) }}" class="text-indigo-600 hover:underline">Update Score</a>
                  @else
                    <a href="{{ route('predictions.create', ['tournament' => optional($match->tournaments->first())->id, 'match' => $match->id]) }}" class="text-green-600 hover:underline">Predict Score</a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
@endsection
