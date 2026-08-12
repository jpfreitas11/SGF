<x-app-layout>
    <x-slot name="header">Historico</x-slot>

    <div class="sgf-page">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">{{ $employee->name }}</h1>
                <p class="sgf-subtitle">Historico salarial e historico de cargos.</p>
            </div>

            <a href="{{ route('employees.index') }}" class="sgf-button-secondary">Voltar</a>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="sgf-card overflow-hidden">
                <div class="border-b border-zinc-200 p-4 dark:border-zinc-800">
                    <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Historico salarial</h2>
                </div>

                <table class="sgf-table">
                    <thead class="bg-zinc-50 dark:bg-zinc-950">
                        <tr>
                            <th class="sgf-th">Antes</th>
                            <th class="sgf-th">Depois</th>
                            <th class="sgf-th">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($employee->salaryHistories as $history)
                            <tr>
                                <td class="sgf-td">R$ {{ number_format($history->old_salary, 2, ',', '.') }}</td>
                                <td class="sgf-td">R$ {{ number_format($history->new_salary, 2, ',', '.') }}</td>
                                <td class="sgf-td">{{ $history->changed_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="sgf-td text-center text-zinc-500">Nenhum historico salarial.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="sgf-card overflow-hidden">
                <div class="border-b border-zinc-200 p-4 dark:border-zinc-800">
                    <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Historico de cargos</h2>
                </div>

                <table class="sgf-table">
                    <thead class="bg-zinc-50 dark:bg-zinc-950">
                        <tr>
                            <th class="sgf-th">Antes</th>
                            <th class="sgf-th">Depois</th>
                            <th class="sgf-th">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($employee->positionHistories as $history)
                            <tr>
                                <td class="sgf-td">{{ $history->oldPosition->title }}</td>
                                <td class="sgf-td">{{ $history->newPosition->title }}</td>
                                <td class="sgf-td">{{ $history->changed_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="sgf-td text-center text-zinc-500">Nenhum historico de cargo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>