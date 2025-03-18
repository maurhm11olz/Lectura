<x-lectura::layouts.main>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-32"> <!-- Menyesuaikan margin-top agar tidak tertutup navbar -->
        <!-- Main Content Section -->
        <div class="relative bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-xl rounded-xl p-8 border border-blue-200">
            <!-- Breadcrumbs Section -->
            <div class="mb-10">
                <x-lectura::breadcrumbs
                    :breadcrumbs="$this->getBreadcrumbs()"
                    class="text-sm text-gray-500 hover:text-gray-700"
                />
            </div>
            <!-- Title Section -->
            <div class="flex items-center mb-6 space-x-4">
                <h1 class="text-4xl font-extrabold text-gray-900">{{ $this->getTitle() }}</h1>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>
            <!-- About Conference Section -->
            @if ($about)
                <div class="user-content bg-white p-6 rounded-lg shadow-lg transition duration-300 ease-in-out hover:shadow-2xl">
                    <p class="text-gray-700 text-lg leading-relaxed">
                        {{ new Illuminate\Support\HtmlString($about) }}
                    </p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center bg-white p-8 rounded-lg shadow-lg text-center transition transform hover:scale-105">
                    <svg class="w-20 h-20 text-blue-400 animate-pulse mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-xl font-semibold text-gray-500">No information provided at this time.</p>
                    <p class="text-gray-400 mt-2 text-sm">Check back later for update.</p>
                </div>
            @endif
        </div>
    </div>
</x-lectura::layouts.main>

