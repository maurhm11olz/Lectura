<x-lectura::layouts.main>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-32">
        <div class="relative bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-xl rounded-xl p-8 border border-blue-200">
            <div class="mb-10">
                <x-lectura::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
            </div>
            <div class="relative">
                <div class="flex mb-5 space-x-4">
                    <h1 class="text-xl font-semibold min-w-fit">{{ $this->getTitle() }}</h1>
                    <hr class="w-full h-px my-auto bg-gray-200 border-0 dark:bg-gray-700">
                </div>
                <div class="prose">
                    {{ new Illuminate\Support\HtmlString($privacyStatement) }}
                </div>
            </div>
        </div>
    </div>
</x-lectura::layouts.main>
