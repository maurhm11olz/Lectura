@use('App\Models\Enums\RegistrationPaymentState')
@use('App\Facades\Setting')

<x-lectura::layouts.main>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-32">
        <div class="relative bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-xl rounded-xl p-8 border border-blue-200">
            <div class="space-y-6 mb-10">
                <x-lectura::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
            </div>

            <div class="flex items-center mb-6">
                <h1 class="text-4xl font-extrabold text-gray-900">📅 Agenda</h1>
                <div class="flex-grow ml-4 border-t border-gray-300"></div>
            </div>

            @if ($isParticipant)
                <p class="mt-4 text-sm text-gray-700">
                    ✅ Please select the event below to confirm your attendance.
                </p>
            @endif

            <div class="mt-6 bg-white shadow-lg rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">Session Name</th>
                            @if ($isParticipant)
                                <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($timelines->isEmpty())
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    ❌ No available agenda.
                                </td>
                            </tr>
                        @endif
                        @foreach ($timelines as $timeline)
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $timeline->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $timeline->date->format(Setting::get('format_date')) }}</div>
                                </td>
                                @if ($isParticipant)
                                    <td class="px-6 py-4 text-center">
                                        @if ($timeline->isOngoing())
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                🟢 On going
                                            </span>
                                        @elseif ($timeline->getEarliestTime()->isFuture())
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                🔵 Not started
                                            </span>
                                        @elseif ($timeline->getLatestTime()->isPast())
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                ⚪ Over
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($timeline->canAttend())
                                            @if ($userRegistration->isAttended($timeline))
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                                    ✅ Confirmed
                                                </span>
                                            @else
                                                <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                wire:click="attend({{ $timeline->id }}, '{{ static::ATTEND_TYPE_TIMELINE }}')">
                                                    🎟️ Attend
                                                </button>
                                            @endif
                                        @else
                                            @if ($userRegistration->isAttended($timeline))
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                                    ✅ Confirmed
                                                </span>
                                            @else
                                                @if ($timeline->getEarliestTime()->isFuture())
                                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
                                                        ⏳ Incoming
                                                    </span>
                                                @elseif ($timeline->getEarliestTime()->isPast())
                                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-red-100 text-red-800">
                                                        ❌ Expired
                                                    </span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-lectura::layouts.main>
