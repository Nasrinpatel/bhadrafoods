@php
    $hasAds = $shortcode->ads_1 || $shortcode->ads_2;
    $style = ! in_array($shortcode->style, ['wooden', 'fashion', 'furniture', 'cosmetics', 'grocery', 'full-width']) ? 'wooden' : $shortcode->style;
    $allowedAutoplaySpeeds = [2000, 3000, 4000, 4500, 5000, 5500, 6000, 7000, 8000, 9000, 10000];
    $defaultAutoplaySpeeds = [
        'wooden' => 4500,
        'grocery' => 4500,
        'full-width' => 4500,
        'furniture' => 5000,
        'fashion' => 5500,
        'cosmetics' => 6000,
    ];
    $autoplaySpeed = (int) $shortcode->autoplay_speed;
    $autoplaySpeed = in_array($autoplaySpeed, $allowedAutoplaySpeeds, true) ? $autoplaySpeed : $defaultAutoplaySpeeds[$style];
@endphp

@if($sliders->isNotEmpty())
    @php $sliders->loadMissing('metadata'); @endphp
    <section @class([
        'slider-area',
        'pb-25' => $style === 'wooden',
        'slider-bg slider-bg-height' => $style === 'fashion',
    ]) @if ($shortcode->background_color) style="background-color: {{ $shortcode->background_color }} !important;" @endif>
        @include(Theme::getThemeNamespace("partials.shortcodes.simple-slider.styles.$style"))
    </section>
@endif
