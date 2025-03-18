<x-lectura::layouts.main>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-32">
        <div class="p-10 space-y-4 mx-auto bg-gradient-to-r from-blue-100 to-blue-300
            backdrop-blur-lg shadow-2xl rounded-3xl border border-gray-200">
            <div class="mb-10">
                <x-lectura::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
            </div>
            <header class="space-y-2">
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $announcement->title }}</h1>
            </header>

            @if ($announcement->hasMedia('featured_image'))
                <div class="relative h-64 overflow-hidden rounded-lg shadow-lg">
                    <img class="object-cover w-full h-full"
                        src="{{ $announcement->getFirstMedia('featured_image')->getAvailableUrl(['thumb']) }}"
                        alt="{{ $announcement->title }}">
                </div>
            @endif

            <div class="prose max-w-none text-gray-800">
                {{ new Illuminate\Support\HtmlString($this->announcement->getMeta('content')) }}
            </div>
        </div>
    </div>
</x-lectura::layouts.main>
