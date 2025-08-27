<div class="mt-6">
    <h2 class="text-lg font-semibold text-indigo-700 mb-3">🏆 Scores</h2>
    @if(!empty($scores) && count($scores))
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-3 py-2">User</th>
                    <th class="px-3 py-2 text-right">Points</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($scores as $score)
                    <tr>
                        <td class="px-3 py-2">{{ $score['user']->name }}</td>
                        <td class="px-3 py-2 text-right">{{ $score['points'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500 text-sm">No scores available.</p>
    @endif
</div>