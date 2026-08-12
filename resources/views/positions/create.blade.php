<x-app-layout>
    <x-slot name="header">Novo cargo</x-slot>

    <div class="sgf-page max-w-3xl">
        <div class="sgf-header">
            <div>
                <h1 class="sgf-title">Novo cargo</h1>
                <p class="sgf-subtitle">Use o nivel para representar a hierarquia da empresa.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('positions.store') }}" class="sgf-card space-y-5 p-6">
            @csrf

            <div>
                <label class="sgf-label" for="title">Nome do cargo</label>
                <input id="title" class="sgf-input mt-2" name="title" placeholder="Ex: Coordenador" value="{{ old('title') }}">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="sgf-label" for="level">Nivel hierarquico</label>
                <input id="level" class="sgf-input mt-2" name="level" type="number" placeholder="Ex: 30" value="{{ old('level') }}">
                @error('level')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="sgf-label" for="reports_to_id">Cargo superior</label>
                <select id="reports_to_id" class="sgf-input mt-2" name="reports_to_id">
                    <option value="">Sem superior direto</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="sgf-button">Salvar cargo</button>
                <a href="{{ route('positions.index') }}" class="sgf-button-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>