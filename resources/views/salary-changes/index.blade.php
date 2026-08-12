<x-app-layout>
    <x-slot name="header">Aumentos</x-slot>

    <div class="sgf-page">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Aumentos salariais</h1>
                <p class="sgf-subtitle">Aprovacoes com historico salarial rastreavel.</p>
            </div>
        </div>

        <div class="sgf-card overflow-hidden">
            <table class="sgf-table">
                <thead class="bg-zinc-50 dark:bg-zinc-950">
                    <tr>
                        <th class="sgf-th">Funcionario</th>
                        <th class="sgf-th">Antes</th>
                        <th class="sgf-th">Depois</th>
                        <th class="sgf-th">Status</th>
                        <th class="sgf-th">Acoes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($requests as $request)
                        <tr>
                            <td class="sgf-td font-medium">{{ $request->employee->name }}</td>
                            <td class="sgf-td">R$ {{ number_format($request->old_salary, 2, ',', '.') }}</td>
                            <td class="sgf-td">R$ {{ number_format($request->new_salary, 2, ',', '.') }}</td>
                            <td class="sgf-td">
                                <span class="sgf-badge bg-amber-50 text-amber-700">{{ $request->status->value }}</span>
                            </td>
                            <td class="sgf-td">
                                @if ($request->status === \App\Enums\RequestStatus::Pending)
                                    <div class="space-y-2">
                                        <form method="POST" action="{{ route('salary-changes.approve', $request) }}" class="flex gap-2">
                                            @csrf
                                            <input class="sgf-input" name="decision_reason" placeholder="Motivo">
                                            <button class="sgf-button" type="submit">Aprovar</button>
                                        </form>
                                        <form method="POST" action="{{ route('salary-changes.reject', $request) }}" class="flex gap-2">
                                            @csrf
                                            <input class="sgf-input" name="decision_reason" placeholder="Motivo">
                                            <button class="sgf-button-danger" type="submit">Reprovar</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-sm text-zinc-500">Decidida</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="sgf-td text-center text-zinc-500">Nenhum aumento encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $requests->links() }}</div>
    </div>
</x-app-layout>