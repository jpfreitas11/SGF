<x-app-layout>
    <x-slot name="header">Novo setor</x-slot>

    <div class="sgf-page max-w-3xl">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Novo setor</h1>
                <p class="sgf-subtitle">Ao salvar, o sistema cria automaticamente um admin para este setor.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('departments.store') }}" class="sgf-card p-6">
            @csrf

            <div>
                <label class="sgf-label" for="name">Nome do setor</label>
                <input id="name" class="sgf-input mt-2" name="name" placeholder="Ex: Recursos Humanos" value="{{ old('name') }}">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="sgf-button">Salvar setor</button>
                <a href="{{ route('departments.index') }}" class="sgf-button-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>