<x-app-layout>
    <x-slot name="header">Novo funcionario</x-slot>

    <div class="sgf-page max-w-4xl">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Novo funcionario</h1>
                <p class="sgf-subtitle">Cadastre dados basicos, setor, cargo e salario inicial.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('employees.store') }}" class="sgf-card p-6">
            @csrf

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="sgf-label" for="name">Nome</label>
                    <input id="name" class="sgf-input mt-2" name="name" value="{{ old('name') }}">
                    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="sgf-label" for="email">Email</label>
                    <input id="email" class="sgf-input mt-2" name="email" type="email" value="{{ old('email') }}">
                    @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="sgf-label" for="document">Documento</label>
                    <input id="document" class="sgf-input mt-2" name="document" value="{{ old('document') }}">
                    @error('document') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="sgf-label" for="salary">Salario</label>
                    <input id="salary" class="sgf-input mt-2" name="salary" type="number" step="0.01" value="{{ old('salary') }}">
                    @error('salary') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="sgf-label" for="hired_at">Data de contratacao</label>
                    <input id="hired_at" class="sgf-input mt-2" type="date" name="hired_at" value="{{ old('hired_at') }}">
                    @error('hired_at') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                @if (auth()->user()->isSuperAdmin())
                    <div>
                        <label class="sgf-label" for="department_id">Setor</label>
                        <select id="department_id" class="sgf-input mt-2" name="department_id">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label class="sgf-label" for="position_id">Cargo</label>
                    <select id="position_id" class="sgf-input mt-2" name="position_id">
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->title }}</option>
                        @endforeach
                    </select>
                    @error('position_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="button" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Salvar</button>
                <a href="{{ route('employees.index') }}" class="sgf-button-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>