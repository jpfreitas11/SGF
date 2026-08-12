<x-app-layout>
    <x-slot name="header">Cargos</x-slot>

    <div class="sgf-page">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Cargos</h1>
                <p class="sgf-subtitle">A hierarquia e definida pelo nivel: quanto maior, mais alto o cargo.</p>
            </div>

            <a href="{{ route('positions.create') }}" class="sgf-button">Novo cargo</a>
        </div>

        <div class="sgf-card overflow-hidden">
            <table class="sgf-table">
                <thead class="bg-zinc-50 dark:bg-zinc-950">
                    <tr>
                        <th class="sgf-th">Cargo</th>
                        <th class="sgf-th">Nivel</th>
                        <th class="sgf-th">Responde para</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($positions as $position)
                        <tr>
                            <td class="sgf-td font-medium">{{ $position->title }}</td>
                            <td class="sgf-td">
                                <span class="sgf-badge bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                                    Nivel {{ $position->level }}
                                </span>
                            </td>
                            <td class="sgf-td">{{ $position->reportsTo?->title ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="sgf-td text-center text-zinc-500">Nenhum cargo cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $positions->links() }}
        </div>
    </div>
</x-app-layout>