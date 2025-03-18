<x-lectura::layouts.main>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-32">
        <div class="relative bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-xl rounded-xl p-8 border border-blue-200">
            <div class="mb-10">
                <x-lectura::breadcrumbs
                    :breadcrumbs="$this->getBreadcrumbs()"
                    class="text-sm text-gray-600 transition-colors duration-300"
                />
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 hover:text-indigo-600 mb-6 transition-colors duration-300">
                📢 Announcements
            </h1>

            <div class="overflow-y-auto space-y-4">
                @forelse ($announcements as $announcement)
                    <div class="bg-gray-50 rounded-lg border border-gray-300 p-4 shadow-sm transition-colors duration-300">
                        <x-scheduledConference::announcement-summary :announcement="$announcement" />
                    </div>
                @empty
                    <div class="bg-gray-100 rounded-lg border border-gray-300 p-6 text-center transition-colors duration-300">
                        <p class="text-gray-500 text-lg">
                            No Announcements created yet.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-lectura::layouts.main>
