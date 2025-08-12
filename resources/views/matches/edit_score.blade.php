<!-- matches/edit_score.blade.php -->

<form action="{{ route('matches.updateScore', ['match' => $match->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="result_home">Home Team Score</label>
    <input type="number" name="result_home" id="result_home" min="0" value="{{ old('result_home', $match->result_home) }}" required>

    <label for="result_away">Away Team Score</label>
    <input type="number" name="result_away" id="result_away" min="0" value="{{ old('result_away', $match->result_away) }}" required>

    <button type="submit">Save Score</button>
</form>
