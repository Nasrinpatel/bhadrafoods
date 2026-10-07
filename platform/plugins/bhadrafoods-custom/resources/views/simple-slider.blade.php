@php
    $autoplaySpeed = (int) $shortcode->autoplay_speed;
    $autoplaySpeed = $autoplaySpeed >= 2000 && $autoplaySpeed <= 10000 ? $autoplaySpeed : 4500;
@endphp

@if($sliders->isNotEmpty())
    @php
        $sliders->loadMissing('metadata');
    @endphp

    <section class="bf-fullscreen-hero-slider" data-autoplay-speed="{{ $autoplaySpeed }}" aria-label="{{ __('Featured products') }}">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    @php($subtitle = $slider->getMetaData('subtitle', true))
                    <div class="swiper-slide">
                        <div class="bf-fullscreen-hero-slide">
                            <div class="bf-fullscreen-hero-image">
                                @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image'))
                            </div>

                            <div class="bf-fullscreen-hero-shade"></div>

                            @if ($shortcode->show_slider_text)
                                <div class="bf-fullscreen-hero-content">
                                    @if ($slider->title)
                                        <div class="bf-fullscreen-hero-badge">
                                            <span aria-hidden="true">✦</span>
                                            <span>{!! BaseHelper::clean($slider->title) !!}</span>
                                        </div>
                                    @endif

                                    @if ($subtitle)
                                        <h1 class="bf-fullscreen-hero-title">{!! BaseHelper::clean($subtitle) !!}</h1>
                                    @elseif ($slider->description)
                                        <h1 class="bf-fullscreen-hero-title">{!! BaseHelper::clean($slider->description) !!}</h1>
                                    @endif

                                    @if ($subtitle && $slider->description)
                                        <p class="bf-fullscreen-hero-subtitle">{!! BaseHelper::clean($slider->description) !!}</p>
                                    @endif

                                    @if (($actionLabel = $slider->getMetaData('action_label', true)) && $slider->link)
                                        <a class="bf-fullscreen-hero-button" href="{{ $slider->link }}">
                                            {{ $actionLabel }} <span aria-hidden="true">→</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
