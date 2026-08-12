<x-app-layout>
    <x-slot name="header">Setores</x-slot>

    <div class="sgf-page">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Setores</h1>
                <p class="sgf-subtitle">Cada setor possui um administrador responsavel criado automaticamente.</p>
            </div>

            <a href="{{ route('departments.create') }}" class="sgf-button">Novo setor</a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="sgf-card overflow-hidden">
            <table class="sgf-table">
                <thead class="bg-zinc-50 dark:bg-zinc-950">
                    <tr>
                        <th class="sgf-th">Nome</th>
                        <th class="sgf-th">Admin responsavel</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($departments as $department)
                        <tr>
                            <td class="sgf-td font-medium">{{ $department->name }}</td>
                            <td class="sgf-td">{{ $department->admin?->name ?? 'Sem admin' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="sgf-td text-center text-zinc-500">Nenhum setor cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>
</x-app-layout>