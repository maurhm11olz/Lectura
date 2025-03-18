@props([
    'title' => null,
])

<x-lectura::layouts.base :title="$title">
    <div class="flex h-full min-h-screen flex-col bg-white">
        @hook('Frontend::Views::Header')

        {{-- Load Header Layout dengan warna teks hitam --}}
        <x-lectura::layouts.header />

        <main class="py-3">
            {{-- Load Main Layout --}}
            {{ $slot }}
        </main>

        {{-- Load Footer Layout --}}
        <x-lectura::layouts.footer />

        @hook('Frontend::Views::Footer')
    </div>
</x-lectura::layouts.base>
