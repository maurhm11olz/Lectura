<x-lectura::layouts.main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-32">
        <div class="relative bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-xl rounded-xl p-8 border border-blue-200">
            <div class="mb-10">
                <x-lectura::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
            </div>

            <div class="flex items-center justify-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-800 flex items-center space-x-3 animate-fade-in">
                    <span>{{ $title }}</span>
                </h1>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                @if ($content)
                    <div class="prose prose-lg max-w-none text-gray-700 animate-fade-in">
                        {{ new Illuminate\Support\HtmlString($content) }}
                    </div>
                @else
                    <div class="text-center py-6 text-gray-500 italic animate-fade-in">
                        {{ __('general.no_content_provided') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</x-lectura::layouts.main>
