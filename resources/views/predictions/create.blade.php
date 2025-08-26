@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
    <h1 class="text-2xl font-bold mb-6">Predict Score</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('predictions.store', ['tournament' => $tournament->id, 'match' => $match->id]) }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="match_ids" value='@json($matchIds)'>
        <div>
            <label class="block font-medium">{{ $match->home_team }}</label>
            <input type="number" name="predicted_home" value="{{ old('predicted_home') }}" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <div>
            <label class="block font-medium">{{ $match->away_team }}</label>
            <input type="number" name="predicted_away" value="{{ old('predicted_away') }}" class="w-full border border-gray-300 rounded p-2" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Save Prediction</button>
    </form>
</div>
@endsection