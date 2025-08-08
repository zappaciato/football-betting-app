@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">🏆 All Tournaments</h1>

    @if($tournaments->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
            No tournaments found.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tournaments as $tournament)
                <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 hover:shadow-xl transition">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $tournament->name }}</h2>
                    <p class="text-gray-600 text-sm mb-1">
                        📅 {{ $tournament->start_date }} → {{ $tournament->end_date }}
                    </p>


                    <div class="mt-4">

                           class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
