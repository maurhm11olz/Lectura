@php 
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationItems = app()->getNavigationItems('user-navigation-menu');
@endphp

<aside class="flex items-center lg:hidden" x-slide-over>
    <button @@click="toggleSlideOver" class="btn btn-square btn-sm btn-ghost">
        <x-heroicon-o-bars-3 class="h-6 w-6 text-gray-500" x-show="!slideOverOpen" x-cloak />
        <x-heroicon-o-x-mark class="h-6 w-6 text-gray-500" x-show="slideOverOpen" x-cloak />
    </button>
    <template x-teleport="body">
        <div x-show="slideOverOpen" @@keydown.window.escape="closeSlideOver" class="relative z-[70]">
            <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @@click="closeSlideOver"
                class="fixed inset-0 backdrop-blur-sm"></div>
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="fixed inset-y-0 flex max-w-full pr-10">
                        <div x-show="slideOverOpen" @@click.away="closeSlideOver"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                            class="w-screen max-w-xs">
                            <div class="bg-white border-neutral-200 border-r shadow-xl h-svh overflow-y-scroll">
                                <div class="navigation-menu-mobile p-4 text-gray-900 flex justify-between items-center border-b border-neutral-300">
                                    <x-lectura::logo :headerLogo="$headerLogo" class="font-bold text-gray-900" />
                                    <button @@click="closeSlideOver" class="btn btn-sm btn-square btn-ghost text-gray-900">
                                        <x-heroicon-o-x-mark class="h-6 w-6" />
                                    </button>
                                </div>
                                <div class="flex flex-col justify-between p-4">
                                    @if($primaryNavigationItems->isNotEmpty())
                                        <div class="primary-navigations-menu-mobile space-y-2">
                                            <ul role="list" class="space-y-2">
                                                @foreach ($primaryNavigationItems as $item)
                                                    @if(!$item->isDisplayed())
                                                        @continue
                                                    @endif
                                                    @if ($item->children->isEmpty())
                                                        <li class="navigation-menu-item relative">
                                                            <x-website::link @class([
                                                                'hover:bg-gray-100 text-gray-900 items-center py-2 px-4 pr-6 text-sm rounded-md outline-none transition-colors flex',
                                                                'text-primary font-semibold' => request()->url() === $item->getUrl(),
                                                                'text-gray-700 font-medium' => request()->url() !== $item->getUrl(),
                                                            ]) :href="$item->getUrl()">
                                                                {{ $item->getLabel() }}
                                                            </x-website::link>
                                                        </li>
                                                    @else
                                                        <li x-data="{ open: false }" class="navigation-menu-item relative">
                                                            <button @@click="open = !open" class="hover:bg-gray-300 text-gray-900 items-center py-2 px-4 pr-6 text-sm rounded-md outline-none transition-colors flex justify-between w-full">
                                                                <span>{{ $item->getLabel() }}</span>
                                                                <svg :class="{ '-rotate-180': open }" class="transition h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                                </svg>
                                                            </button>
                                                            <ul x-show="open" x-collapse class="mt-1 space-y-1 pl-4">
                                                                @foreach ($item->children as $childItem)
                                                                    <li>
                                                                        <x-website::link @class([
                                                                            'hover:bg-gray-500 text-gray-900 items-center py-2 px-4 pr-6 text-sm rounded-md outline-none transition-colors flex',
                                                                            'text-primary font-semibold' => request()->url() === $childItem->getUrl(),
                                                                            'text-gray-700 font-medium' => request()->url() !== $childItem->getUrl(),
                                                                        ]) :href="$childItem->getUrl()">
                                                                            {{ $childItem->getLabel() }}
                                                                        </x-website::link>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="user-navigations-menu-mobile mt-4 border-t border-neutral-300 pt-4">
                                        <ul role="list" class="space-y-2">
                                           @foreach ($userNavigationItems as $item)
                                                @if(!$item->isDisplayed())
                                                    @continue
                                                @endif
                                                @if ($item->children->isEmpty())
                                                    <li class="navigation-menu-item relative">
                                                        <x-website::link @class([
                                                            'hover:bg-gray-500 text-gray-900 items-center py-2 px-4 pr-6 text-sm rounded-md outline-none transition-colors flex',
                                                            'text-primary font-semibold' => request()->url() === $item->getUrl(),
                                                            'text-gray-700 font-medium' => request()->url() !== $item->getUrl(),
                                                        ]) :href="$item->getUrl()">
                                                            {{ $item->getLabel() }}
                                                        </x-website::link>
                                                    </li>
                                                @else
                                                    <li x-data="{ open: false }" class="navigation-menu-item relative">
                                                        <button @@click="open = !open" class="hover:bg-gray-100 text-gray-900 items-center py-2 px-4 pr-6 text-sm rounded-md outline-none transition-colors flex justify-between w-full">
                                                            <span class="flex items-center gap-2">
                                                                <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                    <circle cx="12" cy="8" r="4"></circle>
                                                                    <path d="M6 20a6 6 0 0112 0"></path>
                                                                </svg>
                                                                {{ $item->getLabel() }}
                                                            </span>
                                                            <svg :class="{ '-rotate-180': open }" class="transition h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        </button>
                                                        
                                                        <ul x-show="open" x-collapse class="mt-1 space-y-1 pl-4">
                                                            @foreach ($item->children as $childItem)
                                                                <li>
                                                                    <x-website::link @class([
                                                                        'hover:bg-gray-100 text-gray-900 items-center py-2 px-4 pr-6 text-sm rounded-md outline-none transition-colors flex',
                                                                        'text-primary font-semibold' => request()->url() === $childItem->getUrl(),
                                                                        'text-gray-700 font-medium' => request()->url() !== $childItem->getUrl(),
                                                                    ]) :href="$childItem->getUrl()">
                                                                        {{ $childItem->getLabel() }}
                                                                    </x-website::link>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</aside>
