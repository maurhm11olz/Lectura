@props([
    'breadcrumbs' => [],
])

@if(!empty($breadcrumbs))
<div {{ $attributes->class(['breadcrumbs text-sm bg-blue-100 px-4 py-3 rounded-md']) }}>
    <ul class="flex items-center flex-wrap gap-2">
        @foreach ($breadcrumbs as $url => $label)
            <li class="flex items-center">
                @if(!is_int($url))
                    <x-lectura::link
                        :href="$url"
                        class="text-gray-600 hover:text-blue-800 transition-colors duration-200 font-medium"
                    >
                        {{ $label }}
                    </x-lectura::link>
                @else
                    <span class="text-gray-600">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endif
