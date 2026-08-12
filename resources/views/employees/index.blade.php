<x-app-layout>
    <x-slot name="header">Funcionarios</x-slot>

    <div class="sgf-page">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Funcionarios</h1>
                <p class="sgf-subtitle">Gerencie funcionarios, historico e solicitacoes.</p>
            </div>

            <a href="{{ route('employees.create') }}" class="sgf-button">Novo funcionario</a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4">
            @forelse ($employees as $employee)
                <div class="sgf-card p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $employee->name }}</h2>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $employee->email }} · {{ $employee->document }}</p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="sgf-badge bg-blue-50 text-blue-700">{{ $employee->department->name }}</span>
                                <span class="sgf-badge bg-zinc-100 text-zinc-700">{{ $employee->position->title }}</span>
                                <span class="sgf-badge bg-green-50 text-green-700">R$ {{ number_format($employee->salary, 2, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a class="sgf-button-secondary" href="{{ route('employees.history', $employee) }}">Historico</a>

                            <form method="POST" action="{{ route('employees.destroy', $employee) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sgf-button-danger">Arquivar</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-4 lg:grid-cols-3">
                        <form method="POST" action="{{ route('transfers.store', $employee) }}" class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-800">
                            @csrf
                            <h3 class="font-medium text-zinc-900 dark:text-zinc-100">Transferencia</h3>
                            <select class="sgf-input mt-3" name="to_department_id">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <input class="sgf-input mt-3" name="reason" placeholder="Motivo">
                            <button type="submit" class="sgf-button mt-3 w-full">Solicitar</button>
                        </form>

                        <form method="POST" action="{{ route('salary-changes.store', $employee) }}" class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-800">
                            @csrf
                            <h3 class="font-medium text-zinc-900 dark:text-zinc-100">Aumento</h3>
                            <input class="sgf-input mt-3" name="new_salary" type="number" step="0.01" placeholder="Novo salario">
                            <input class="sgf-input mt-3" name="reason" placeholder="Motivo">
                            <button type="submit" class="sgf-button mt-3 w-full">Solicitar</button>
                        </form>

                        <form method="POST" action="{{ route('position-changes.store', $employee) }}" class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-800">
                            @csrf
                            <h3 class="font-medium text-zinc-900 dark:text-zinc-100">Promocao</h3>
                            <select class="sgf-input mt-3" name="new_position_id">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                                @endforeach
                            </select>
                            <input class="sgf-input mt-3" name="reason" placeholder="Motivo">
                            <button type="submit" class="sgf-button mt-3 w-full">Solicitar</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sgf-card p-8 text-center text-zinc-500">
                    Nenhum funcionario cadastrado.
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $employees->links() }}
        </div>
    </div>
</x-app-layout>