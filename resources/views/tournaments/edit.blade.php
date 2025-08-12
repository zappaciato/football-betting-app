@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Edit Tournament: {{ $tournament->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tournament Edit Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST" class="mb-4">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tournament Name</label>
                    <input type="text" name="name" class="form-control" 
                           value="{{ old('name', $tournament->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $tournament->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input 
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        value="{{ old('start_date', $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d') : '') }}" 
                        class="form-control" 
                        required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date (Latest Match Date)</label>
                    <input 
                        type="date" 
                        id="end_date" 
                        name="end_date" 
                        value="{{ old('end_date', $latestMatchDate ? \Carbon\Carbon::parse($latestMatchDate)->format('Y-m-d') : '') }}" 
                        class="form-control" 
                        readonly>
                    <small class="form-text text-muted">Automatically set to the latest match date in this tournament</small>
                </div>

                <button type="submit" class="btn btn-primary">Update Tournament</button>
            </form>
        </div>
    </div>

    {{-- Users Section --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Participants</div>
                <div class="card-body">
                    @forelse($tournament->users as $user)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>{{ $user->name }}</span>
                            <form action="{{ route('tournaments.users.remove', [$tournament->id, $user->id]) }}" method="POST" onsubmit="return confirm('Remove this user?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </div>
                    @empty
                        <p>No participants yet.</p>
                    @endforelse

                    <hr>
                    <form action="{{ route('tournaments.users.add', $tournament->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <select name="user_id" class="form-select">
                                @foreach($allUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Matches Section --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-warning">Matches</div>
                <div class="card-body">
                    @forelse($tournament->matches as $match)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>
                                {{ $match->home_team }} vs {{ $match->away_team }} 
                                ({{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }})
                            </span>
                            <form action="{{ route('tournaments.matches.remove', [$tournament->id, $match->id]) }}" method="POST" onsubmit="return confirm('Remove this match?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </div>
                    @empty
                        <p>No matches yet.</p>
                    @endforelse

                    <hr>
                    <form action="{{ route('tournaments.matches.add', $tournament->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <select name="match_id" class="form-select">
                                @foreach($allMatches as $match)
                                    <option value="{{ $match->id }}">
                                        {{ $match->home_team }} vs {{ $match->away_team }} ({{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }})
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
