<section class="hero-banner bg-gradient-to-r relative bg-[#FAFAFA] text-black py-20 -mt-40">
    <div class="relative w-full h-[calc(110vh+6rem)] overflow-hidden">
        @php
            $images = $currentScheduledConference->getMedia('lectura-header');
            $imageUrls = [];

            foreach ($images as $image) {
                $imageUrls[] = $image->getAvailableUrl(['thumb', 'thumb-xl']);
            }
        @endphp

        @if(count($imageUrls) > 0)
            <div class="absolute inset-0 top-[-2rem] w-full h-full parallax-bg brightness-50"
                style="background-image: url('{{ $imageUrls[0] }}');"></div>
        @else
            <div class="absolute inset-0 bg-gray-300 flex items-center justify-center">
                <span class="text-gray-500 text-xl">Default Image</span>
            </div>
        @endif
        @if($currentScheduledConference->date_start || $currentScheduledConference->date_end)
            <div class="absolute inset-0 flex flex-col items-left justify-center text-left px-4 ml-10 mt-32 backdrop-brightness-100">
                @php
                    $layouts = App\Facades\Plugin::getPlugin('Lectura')->getSetting('layouts');
                @endphp
                    <div class="prose prose-li: max-w-none w-full">
                        @if (!empty($layouts) && isset($layouts[0]))
                            <div class="layout-section">
                                {{ new Illuminate\Support\HtmlString($layouts[0]['data']['about']) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center mb-10">
                        <span class="icon-banner mr-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            <span class="font-semibold text-white">
                                @if($currentScheduledConference->date_start)
                                    {{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}
                                @endif
                                @if($currentScheduledConference->date_end)
                                    - {{ $currentScheduledConference->date_end->format(Setting::get('format_date')) }}
                                @endif
                            </span>
                            <span class="ml-2 text-sm text-gray-400">Conference Dates</span>
                        </div>
                    </div>
            @endif

            @if($theme->getSetting('banner_buttons'))
            <div class="flex flex-wrap justify-left space-x-4">
                @foreach($theme->getSetting('banner_buttons') ?? [] as $button)
                    <a
                        href="{{ data_get($button, 'url') }}"
                        class="px-6 py-3 font-semibold rounded-full shadow-lg transition duration-300
                            {{ $loop->first ? 'bg-yellow-500 text-white' : 'border-2 border-white text-white bg-transparent' }}"
                    >
                        {{ data_get($button, 'text') }}
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

<style>
    .parallax-bg {
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
</style>
