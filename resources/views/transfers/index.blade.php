<x-app-layout>
    <x-slot name="header">Transferencias</x-slot>

    <div class="sgf-page">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Transferencias</h1>
                <p class="sgf-subtitle">Solicitacoes decididas pelo setor de destino.</p>
            </div>
        </div>

        <div class="sgf-card overflow-hidden">
            <table class="sgf-table">
                <thead class="bg-zinc-50 dark:bg-zinc-950">
                    <tr>
                        <th class="sgf-th">Funcionario</th>
                        <th class="sgf-th">Origem</th>
                        <th class="sgf-th">Destino</th>
                        <th class="sgf-th">Status</th>
                        <th class="sgf-th">Acoes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($requests as $request)
                        <tr>
                            <td class="sgf-td font-medium">{{ $request->employee->name }}</td>
                            <td class="sgf-td">{{ $request->fromDepartment->name }}</td>
                            <td class="sgf-td">{{ $request->toDepartment->name }}</td>
                            <td class="sgf-td">
                                <span class="sgf-badge bg-amber-50 text-amber-700">{{ $request->status->value }}</span>
                            </td>
                            <td class="sgf-td">
                                @if ($request->status === \App\Enums\RequestStatus::Pending)
                                    <div class="space-y-2">
                                        <form method="POST" action="{{ route('transfers.approve', $request) }}" class="flex gap-2">
                                            @csrf
                                            <input class="sgf-input" name="decision_reason" placeholder="Motivo">
                                            <button class="sgf-button" type="submit">Aprovar</button>
                                        </form>
                                        <form method="POST" action="{{ route('transfers.reject', $request) }}" class="flex gap-2">
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
                            <td colspan="5" class="sgf-td text-center text-zinc-500">Nenhuma transferencia encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $requests->links() }}</div>
    </div>
</x-app-layout>