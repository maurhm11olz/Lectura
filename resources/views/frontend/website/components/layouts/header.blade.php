@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationMenu = app()->getNavigationItems('user-navigation-menu');
@endphp


@if(app()->getCurrentConference() || app()->getCurrentScheduledConference())
    <div id="navbar" class="navbar-container bg-transparent text-yellow-500 z-50 transition-all duration-300 fixed w-full top-0 left-0">
        @if(App\Facades\Plugin::getPlugin('Lectura')->getSetting('top_navigation'))
        <div class="navbar-publisher bg-black font-semibold">
            <div class="container mx-auto px-4 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-x-4">
                    <x-lectura::logo
                        :headerLogo="app()->getSite()->getFirstMedia('logo')?->getAvailableUrl(['thumb', 'thumb-xl'])"
                        :headerLogoAltText="app()->getSite()->getMeta('name')"
                        :homeUrl="url('/')"
                        class="text-yellow-500 h-8 w-auto"
                    />
                    @if(App\Models\Conference::exists())
                        @livewire(App\Livewire\GlobalNavigation::class)
                    @endif
                </div>
                <div class="hidden lg:flex items-center gap-x-6">
                    <x-lectura::navigation-menu
                        :items="$userNavigationMenu"
                        class="flex items-center gap-x-6 text-black hover:text-gray-200 transition-colors duration-200"
                    />
                </div>
            </div>
        </div>
        @endif
        <div class="navbar mx-auto max-w-7xl px-8 py-6 justify-between">
            <div class="navbar-start items-center w-max gap-4">
                <x-lectura::navigation-menu-mobile />
                <x-lectura::logo :headerLogo="$headerLogo" class="text-1xl lg:text-2xl"/>
            </div>
            <div class="navbar-end hidden lg:flex relative z-10 w-max text-lg">
                <x-lectura::navigation-menu :items="$primaryNavigationItems" class="text-xl lg:text-xl"/>
            </div>
        </div>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let navbar = document.getElementById("navbar");
        window.addEventListener("scroll", function () {
            console.log("Scroll position:", window.scrollY);
            if (window.scrollY > 50) {
                navbar.classList.add("bg-white", "text-black", "shadow-md");
                navbar.classList.remove("bg-transparent", "text-yellow-500");
            } else {
                navbar.classList.add("bg-transparent", "text-yellow-500");
                navbar.classList.remove("bg-white", "text-black", "shadow-md");
            }
        });
    });
</script>
