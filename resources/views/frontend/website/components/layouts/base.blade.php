@props([
    'title' => null,
])
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    >
    <x-lectura::layouts.head :title="$title" />

    <body class="page antialiased text-black" x-data>

        {{ $slot }}

        @livewireScriptConfig

        @hook('Frontend::Views::Body::End')
    </body>

</html>
