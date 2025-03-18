<x-lectura::layouts.main>

    <x-lectura::layouts.banner></x-lectura::layouts.banner>
    {{-- banner - text header --}}
    <div class="space-y-6 bg-white">
        <x-scheduledConference::alert-scheduled-conference :scheduled-conference="$currentScheduledConference" />
        @if ($currentScheduledConference->hasMedia('cover')||$currentScheduledConference->getMeta('about')||$currentScheduledConference->getMeta('additional_content'))
            {{-- <section id="highlight" class="space-y-4">
                <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 gap-4">
                    <div class="flex flex-col gap-4 flex-1">
                        @if ($currentScheduledConference->hasMedia('cover'))
                            <div class="cfcover">
                                <img class="h-full"
                                    src="{{ $currentScheduledConference->getFirstMedia('cover')->getAvailableUrl(['thumb', 'thumb-xl']) }}"
                                    alt="{{ $currentScheduledConference->title }}" />
                            </div>
                        @endif
                        @if ($currentScheduledConference->getMeta('about'))
                            <div class="user-content">
                                {{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('about')) }}
                            </div>
                        @endif
                        @if ($currentScheduledConference->getMeta('additional_content'))
                            <div class="user-content">
                                {{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('additional_content')) }}
                            </div>
                        @endif
                    </div>
                </div>
            </section> --}}
        @endif
        @if ($currentScheduledConference?->speakers->isNotEmpty())
        <section id="speakers" class="py-8 px-8 md:px-24 lg:px-32 bg-white">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-black">
                    <span class="text-yellow-500">Event</span> Speakers
                </h2>
                <p class="text-gray-600 mt-2 text-sm">We invite digital experts around the world</p>
            </div>

            @php
                $allSpeakers = collect();
                foreach ($currentScheduledConference->speakerRoles as $role) {
                    if ($role->speakers->isNotEmpty()) {
                        $allSpeakers = $allSpeakers->merge($role->speakers);
                    }
                }
            @endphp

            @if ($allSpeakers->count() > 0)
                {{-- Baris pertama: 3 pembicara --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10 mb-8">
                    @foreach ($allSpeakers->take(3) as $speaker)
                        <div class="text-center">
                            <img class="w-full h-96 object-cover"
                                 src="{{ $speaker->getFilamentAvatarUrl() }}"
                                 alt="{{ $speaker->fullName }}" />
                            <h3 class="text--base text-black font-bold mt-5">{{ $speaker->fullName }}</h3>
                            <div class="text-xs text-orange-400">{{ $speaker->role->name ?? 'No role assigned' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            @php
                $remainingSpeakers = $allSpeakers->slice(3);
            @endphp

            @if ($remainingSpeakers->isNotEmpty())
                {{-- Baris kedua: 4 pembicara --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-20">
                    @foreach ($remainingSpeakers->take(4) as $speaker)
                        <div class="text-center">
                            <img class="w-full h-72 object-cover"
                                 src="{{ $speaker->getFilamentAvatarUrl() }}"
                                 alt="{{ $speaker->fullName }}" />
                            <h3 class="text-base text-black font-bold mt-5">{{ $speaker->fullName }}</h3>
                            <div class="text-xs text-orange-400">{{ $speaker->role->name ?? 'No role assigned' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    @php
        $plugin = App\Facades\Plugin::getPlugin('Lectura');
        $layouts = App\Facades\Plugin::getPlugin('Lectura')->getSetting('layouts');
        $timelines = App\Models\Timeline::with('sessions')->where('hide', false)->orderBy('date', 'asc')->get();

    @endphp
    {{-- layout 2 --}}
    <div class="prose prose-li: max-w-none w-full bg-white">
        <div class="prose prose-li: max-w-none w-full">
            @if (!empty($layouts) && isset($layouts[1]))
                <div class="layout-section">
                    {{ new Illuminate\Support\HtmlString($layouts[1]['data']['about']) }}
                </div>
            @endif
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="p-3">
            @if($timelines->isNotEmpty())
                <section class="bg-white">
                    <div class="text-center mb-12">
                        <h2 id="speakers" class="text-4xl font-bold text-black">
                            <span class="text-yellow-500">Event</span> Schedules
                        </h2>
                        <p class="text-gray-600 mt-2 text-sm">Do not miss it and be sure to attend</p>
                    </div>

                    <div class="relative w-full flex justify-center items-center">
                        <button id="prev-btn" class="hidden md:block absolute left-2 bg-yellow-500 text-white px-3 py-2">&lt;</button>
                        <div id="day-container" class="flex overflow-x-auto md:overflow-hidden md:flex-nowrap items-center border border-yellow-500 bg-white px-5 py-2 space-x-2">
                            @foreach ($timelines as $index => $timeline)
                                <button class="day-btn px-4 py-2 text-center border border-yellow-500 flex flex-col items-center text-gray-800 hover:bg-gray-300 transition duration-300
                                    {{ $index === 0 ? 'bg-yellow-500 text-white active' : '' }}"
                                    data-day="{{ $index }}">
                                    <h2 class="text-base font-bold day-text {{ $index === 0 ? 'text-white' : 'text-black' }}">
                                        {{ \Carbon\Carbon::parse($timeline->date)->translatedFormat('j F, Y') }}
                                    </h2>
                                    <p class="text-xs text-gray-600 mt-1">{{ $timeline->name ?? 'No Event Name' }}</p>
                                </button>
                            @endforeach
                        </div>
                        <button id="next-btn" class="hidden md:block absolute right-2 bg-yellow-500 text-white px-3 py-2">&gt;</button>
                    </div>

                    <div class="mt-8 max-w-4xl mx-auto">
                        @foreach ($timelines as $index => $timeline)
                            <div class="schedule-content {{ $index !== 0 ? 'hidden' : '' }}" data-day="{{ $index }}">
                                @foreach ($timeline->sessions as $session)
                                    <div class="grid grid-cols-12 gap-4 py-6 border-b border-gray-200">
                                        <div class="col-span-2 flex items-center text-gray-500 text-sm font-semibold">
                                            {{ \Carbon\Carbon::parse($session->start_at)->format('H:i A') }} -
                                            {{ \Carbon\Carbon::parse($session->end_at)->format('H:i A') }}
                                        </div>
                                        <div class="col-span-10">
                                            <h3 class="text-xl font-bold text-gray-900">{{ $session->name }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">
                                                @if($session->public_details === strip_tags($session->public_details))
                                                    {{ $session->public_details }}
                                                @else
                                                    {!! $session->public_details !!}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </section>
            @else
                <div class="text-center py-6">
                    <p class="text-lg text-gray-500">No schedules yet.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("day-container");
            const prevBtn = document.getElementById("prev-btn");
            const nextBtn = document.getElementById("next-btn");
            const buttons = document.querySelectorAll(".day-btn");
            const contents = document.querySelectorAll(".schedule-content");

            let currentStart = 0;
            const maxVisible = 5;

            function updateVisibility() {
                buttons.forEach((btn, index) => {
                    btn.classList.toggle("hidden", index < currentStart || index >= currentStart + maxVisible);
                });

                prevBtn.classList.toggle("hidden", currentStart === 0);
                nextBtn.classList.toggle("hidden", currentStart + maxVisible >= buttons.length);
            }

            prevBtn.addEventListener("click", function () {
                if (currentStart > 0) {
                    currentStart--;
                    updateVisibility();
                }
            });

            nextBtn.addEventListener("click", function () {
                if (currentStart + maxVisible < buttons.length) {
                    currentStart++;
                    updateVisibility();
                }
            });

            updateVisibility();

            buttons.forEach((button) => {
                button.addEventListener("click", function () {
                    const selectedDay = this.getAttribute("data-day");

                    buttons.forEach((btn) => {
                        btn.classList.remove("bg-yellow-500", "text-white");
                        btn.classList.add("text-gray-800", "hover:bg-gray-300");
                        btn.querySelector(".day-text").classList.remove("text-white");
                        btn.querySelector(".day-text").classList.add("text-black");
                    });

                    this.classList.add("bg-yellow-500", "text-white");
                    this.classList.remove("text-gray-800", "hover:bg-gray-300");
                    this.querySelector(".day-text").classList.add("text-white");
                    this.querySelector(".day-text").classList.remove("text-black");

                    contents.forEach((content) => {
                        content.classList.add("hidden");
                    });
                    document.querySelector(`.schedule-content[data-day="${selectedDay}"]`).classList.remove("hidden");
                });
            });
        });
    </script>
    {{-- layout 3 --}}
    <div class="prose prose-li: max-w-none w-full bg-white">
        <div class="prose prose-li: max-w-none w-full">
            @if (!empty($layouts) && is_array($layouts) && isset($layouts[2]['data']['about']))
                <div class="layout-section">
                    {{ new Illuminate\Support\HtmlString($layouts[2]['data']['about']) }}
                </div>
            @endif
        </div>
    </div>
<!-- Swiper.js CDN layout 2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script>
            var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                768: { slidesPerView: 2 }
            }
            });
        </script>
    </div>
        @if($sponsorLevels->isNotEmpty() || $sponsorsWithoutLevel->isNotEmpty())
            <section id="sponsors" class="sponsors text-center py-12 mt-20">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 id="speakers" class="text-4xl font-bold text-black">
                            <span class="text-yellow-500">Event</span> Sponsors
                        </h2>
                        <p class="text-gray-600 mt-2 text-sm">Check who make this event possible</p>
                    </div>
                    <div class="conference-sponsor-levels space-y-6 text-black font-bold">
                        @if($sponsorsWithoutLevel->isNotEmpty())
                            <div class="conference-sponsor-level">
                                <div class="conference-sponsors flex justify-center flex-wrap items-center gap-4">
                                    @foreach($sponsorsWithoutLevel as $sponsor)
                                        @if(!$sponsor->getFirstMedia('logo'))
                                            @continue
                                        @endif
                                        <x-scheduledConference::conference-sponsor :sponsor="$sponsor" />
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @foreach ($sponsorLevels as $sponsorLevel)
                            <div class="conference-sponsor-level">
                                <h3 class="text-lg mb-4">{{ $sponsorLevel->name }}</h3>
                                <div class="conference-sponsors flex justify-center flex-wrap items-center gap-4">
                                    @foreach($sponsorLevel->stakeholders as $sponsor)
                                        @if(!$sponsor->getFirstMedia('logo'))
                                            @continue
                                        @endif
                                        <x-scheduledConference::conference-sponsor :sponsor="$sponsor" />
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        @if ($currentScheduledConference)
        <section class="latest-news section-background py-24">
            <div class="container mx-auto px-4 max-w-7xl">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 id="speakers" class="text-4xl font-bold text-black">
                        <span class="text-yellow-500">Latest</span> News
                    </h2>
                    <p class="text-gray-600 mt-2 text-sm"></p>
                </div>

                @if ($currentScheduledConference->announcements()
                ->where(function ($query) {
                    $query->where('expires_at', '>', now()->startOfDay())
                        ->orWhereNull('expires_at');
                })->count() > 0)

                    <!-- Announcements Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($currentScheduledConference->announcements()
                        ->where(function ($query) {
                            $query->where('expires_at', '>', now()->startOfDay())
                                ->orWhereNull('expires_at');
                        })
                        ->orderBy('created_at', 'DESC')
                        ->take(3)
                        ->get() as $announcement)

                            @php
                                $content = $announcement->getMeta('content');
                                preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
                                $imageUrl = $matches[1] ?? '';
                            @endphp

                            <article
                                class="group relative bg-white rounded-3xl shadow-lg hover:shadow-xl transition-all duration-500 ease-in-out transform hover:-translate-y-1">
                                <!-- Image Section -->
                                <div class="relative h-64 rounded-t-3xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-black/30 z-10">
                                    </div>


                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <span class="text-gray-500 text-xl">No Image Available</span>
                                        </div>
                                    @endif
                                    <!-- Date Badge -->
                                    <div class="absolute top-4 left-4 z-20">
                                        <div
                                            class="flex items-center space-x-1 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full">
                                            <svg class="color-latest w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-800">
                                                {{ $announcement->created_at->format(Setting::get('format_date')) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Content Section -->
                                <div class="relative p-8 bg-white/80 backdrop-blur-sm rounded-b-3xl">
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 transition-colors duration-300">
                                        <a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}"
                                            class="block hover:text-blue-600">
                                            {{ $announcement->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                                        {{ $announcement->getMeta('summary') }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}"
                                            class="inline-flex items-center group/link">
                                            <span
                                                class="text-sm font-semibold color-latest group-hover/link:color-latest transition-colors duration-200">
                                                Read full announcement
                                            </span>
                                            <svg class="w-5 h-5 ml-2 color-latest transform transition-transform duration-300 group-hover/link:translate-x-1"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <!-- View All Link -->
                    <div class="mt-16 text-center">
                        <a href="{{ route(App\Frontend\ScheduledConference\Pages\Announcements::getRouteName('scheduledConference')) }}"
                            class="button-banner submit inline-flex items-center px-8 py-3 text-base font-medium text-black rounded-full hover:opacity-90 transition-opacity">
                            View All Updates
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16 px-4">
                        <div class="max-w-md mx-auto">
                            <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3 class="mt-4 text-xl font-semibold text-gray-900">No Announcements Yet</h3>
                            <p class="mt-2 text-gray-600">Stay tuned! New announcements will be posted here as they
                                become available.</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        @endif

        @if($partners->isNotEmpty())
        <section class="partners mt-20">
            <div class="text-center mb-12">
                <h2 id="speakers" class="text-4xl font-bold text-black">
                    <span class="text-yellow-500">Our</span> Partners
                </h2>
                <p class="text-gray-600 mt-2 text-sm">Meet the amazing sponsors & collaborators who make this event possible.</p>
            </div>
            <div class="conference-partners flex flex-wrap justify-center items-center gap-6">
                @foreach($partners as $partner)
                    @if(!$partner->getFirstMedia('logo'))
                        @continue
                    @endif
                    <div class="w-24 h-24 flex justify-center items-center bg-black shadow-lg rounded-full overflow-hidden">
                        <img src="{{ $partner->getFirstMediaUrl('logo') }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        </section>
        @endif
        {{-- layout 2 --}}
        <div class="prose prose-li: max-w-none w-full mt-[-100]">
            <div class="prose prose-li: max-w-none w-full">
                @if (!empty($layouts) && isset($layouts[3]))
                    <div class="layout-section">
                        {{ new Illuminate\Support\HtmlString($layouts[3]['data']['about']) }}
                    </div>
                @endif
            </div>
            {{-- about - layouts 4 dst--}}
            @if (count($layouts) > 4)
                @foreach ($layouts as $index => $layout)
                    @if ($index >= 4)
                        <div class="layout-section">
                            {{ new Illuminate\Support\HtmlString($layout['data']['about']) }}
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</x-lectura::layouts.main>
