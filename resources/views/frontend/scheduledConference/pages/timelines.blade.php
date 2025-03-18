<x-lectura::layouts.main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mt-24">
        <div class="relative bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 shadow-xl rounded-xl p-8 border border-blue-200">
            <div class="mb-10">
                <x-lectura::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
            </div>
            <div class="flex mb-6 items-center space-x-4">
                <h1 class="text-3xl font-bold text-gray-900">📌 Event Timelines</h1>
            </div>

            @php
                $timelines = App\Models\Timeline::with('sessions')->where('hide', false)->orderBy('date', 'asc')->get();
            @endphp

            @if($timelines->isNotEmpty())
                <ol class="relative border-l-4 border-yellow-500 ml-5">
                    @foreach ($timelines as $timeline)
                        <li class="mb-12 ml-6 group">
                            <div class="absolute w-5 h-5 bg-white border-4 border-yellow-500 rounded-full -left-3 transform transition-transform duration-300 group-hover:scale-125"></div>

                            <time class="block mb-1 text-sm font-medium text-gray-500">
                                📅 {{ $timeline->date->format(Setting::get('format_date')) }}
                            </time>

                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-yellow-600 transition-colors duration-300">
                                {{ $timeline->name }}
                            </h3>
                            @if($timeline->sessions->isNotEmpty())
                                <ul class="mt-4 ml-6">
                                    @foreach ($timeline->sessions as $session)
                                        <li class="mb-4 p-4 bg-gray-50 border-l-4 border-yellow-300 rounded-lg shadow hover:bg-yellow-100 transition">
                                            <!-- Attendance Time -->
                                            <p class="text-sm text-gray-600">
                                                ⏰ <strong>{{ \Carbon\Carbon::parse($session->start_at)->format('H:i A') }} -
                                                    {{ \Carbon\Carbon::parse($session->end_at)->format('H:i A') }}</strong>
                                            </p>
                                            <p class="text-md font-semibold text-gray-800">
                                                📌 {{ $session->name }}
                                            </p>

                                            <p class="text-gray-600 text-sm italic mt-2">
                                                🏷 <strong>Public Details:</strong>
                                                @if($session->public_details === strip_tags($session->public_details))
                                                    {{ $session->public_details }}
                                                @else
                                                    {!! $session->public_details !!}
                                                @endif
                                            </p>

                                            @if(auth()->check())
                                            <p class="text-gray-800 text-sm mt-2">
                                                🔒 <strong>Details:</strong>
                                                @if($session->details === strip_tags($session->details))
                                                    {{ $session->details }}
                                                @else
                                                    {!! $session->details !!}
                                                @endif
                                            </p>
                                            @endif
                                            <p class="mt-2 text-sm">
                                                @if($session->require_attendance)
                                                    ✅ <span class="text-green-600 font-semibold">Kehadiran Wajib</span>
                                                @else
                                                    ❌ <span class="text-red-500 font-semibold">Tidak Wajib</span>
                                                @endif
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="ml-6 text-sm text-gray-500">⚠ Tidak ada sesi dalam event ini.</p>
                            @endif
                        </li>
                    @endforeach
                </ol>
            @else
                <div class="text-center py-8">
                    <p class="text-lg text-gray-500">⏳ Belum ada event yang tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</x-lectura::layouts.main>
