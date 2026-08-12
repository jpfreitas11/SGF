<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="sgf-page">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Visao geral</h1>
                <p class="sgf-subtitle">Acompanhe funcionarios, solicitacoes e atalhos principais do SGF.</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sgf-card p-5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Funcionarios</p>
                <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $employeesCount }}</p>
            </div>

            <div class="sgf-card p-5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Transferencias pendentes</p>
                <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $pendingTransfers }}</p>
            </div>

            <div class="sgf-card p-5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Aumentos pendentes</p>
                <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $pendingSalaryChanges }}</p>
            </div>

            <div class="sgf-card p-5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Promocoes pendentes</p>
                <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $pendingPositionChanges }}</p>
            </div>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="sgf-card p-5">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Setores</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Cadastro de departamentos e admins responsaveis.</p>
                <a class="sgf-button mt-4" href="{{ route('departments.index') }}">Abrir setores</a>
            </div>

            <div class="sgf-card p-5">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Cargos</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Hierarquia por nivel e cargo superior.</p>
                <a class="sgf-button mt-4" href="{{ route('positions.index') }}">Abrir cargos</a>
            </div>

            <div class="sgf-card p-5">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Funcionarios</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Gestao, historico, transferencias e solicitacoes.</p>
                <a class="sgf-button mt-4" href="{{ route('employees.index') }}">Abrir funcionarios</a>
            </div>

            <div class="sgf-card p-5">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Transferencias</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Aprovacao pelo setor de destino.</p>
                <a class="sgf-button mt-4" href="{{ route('transfers.index') }}">Abrir transferencias</a>
            </div>

            <div class="sgf-card p-5">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Aumentos</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Aprovacao e historico salarial.</p>
                <a class="sgf-button mt-4" href="{{ route('salary-changes.index') }}">Abrir aumentos</a>
            </div>

            <div class="sgf-card p-5">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Promocoes</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Aprovacao e historico de cargos.</p>
                <a class="sgf-button mt-4" href="{{ route('position-changes.index') }}">Abrir promocoes</a>
            </div>
        </div>
    </div>
</x-app-layout>