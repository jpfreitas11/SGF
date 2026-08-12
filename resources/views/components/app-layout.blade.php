<x-layouts::app :title="$header ?? null">
    @isset($header)
        <flux:heading size="xl" class="mb-4">{{ $header }}</flux:heading>
    @endisset
    {{ $slot }}
</x-layouts::app>
