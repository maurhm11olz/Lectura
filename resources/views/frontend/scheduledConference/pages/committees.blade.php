<x-lectura::layouts.main>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-10 mt-24">
        <div class="relative bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-lg rounded-2xl p-8 border border-blue-300">

            <!-- Breadcrumbs -->
            <div class="mb-10">
                <x-lectura::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
            </div>

            <!-- Title -->
            <div class="items-center mb-6 space-x-4">
                <h1 class="text-2xl font-semibold text-gray-900">📌 List Committee</h1>
            </div>

            <div class="space-y-6">
                @forelse ($committeeRoles as $role)
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-4">{{ $role->name }}</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($role->committees as $committee)
                                <div class="bg-white shadow-md border border-gray-200 rounded-xl p-5 hover:shadow-xl transition-transform transform hover:-translate-y-1">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-400">
                                            <img src="{{ $committee->getFilamentAvatarUrl() }}"
                                                 alt="{{ $committee->fullName }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-lg font-semibold text-gray-900">{{ $committee->fullName }}</p>
                                            @if ($committee->hasMeta('affiliation'))
                                                <span class="text-sm text-gray-600">{{ $committee->getMeta('affiliation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 text-lg">
                        ⏳ No committees found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-lectura::layouts.main>
