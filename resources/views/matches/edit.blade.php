<!-- matches/edit.blade.php -->

<form action="{{ route('matches.update', $match->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="home_team">Home Team</label>
    <input type="text" name="home_team" id="home_team" value="{{ old('home_team', $match->home_team) }}" required>

    <label for="away_team">Away Team</label>
    <input type="text" name="away_team" id="away_team" value="{{ old('away_team', $match->away_team) }}" required>

    <label for="match_date">Match Date</label>
    <input type="datetime-local" name="match_date" id="match_date" value="{{ old('match_date', \Carbon\Carbon::parse($match->match_date)->format('Y-m-d\TH:i')) }}" required>

    <button type="submit">Save Match Info</button>
</form>

<a href="{{ route('matches.editScore', ['match' => $match->id, 'tournament' => $tournament->id ?? null]) }}" 
   class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
   Update Score
</a>
