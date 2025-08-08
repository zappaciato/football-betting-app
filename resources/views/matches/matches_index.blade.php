@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6">Matches</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($matches->count() > 0)
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tournament ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Home Team</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Away Team</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Match Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($matches as $match)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $match->tournament_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $match->home_team }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $match->away_team }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($match->match_date)->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="">Edit</a>
                                <form action="" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600">No matches found.</p>
    @endif

    <div class="mt-6">
    </a>
    </div>
</div>
@endsection
