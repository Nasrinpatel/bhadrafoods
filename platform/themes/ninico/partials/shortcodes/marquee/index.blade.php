@php
    $speed = $shortcode->speed ?: 40;
    $bgColor = $shortcode->background_color ?: '#8a6116';
    $textColor = $shortcode->text_color ?: '#ffffff';
@endphp

<div class="marquee-wrapper" style="background-color: {{ $bgColor }};">
    <div class="marquee" style="animation-duration: {{ $speed }}s; color: {{ $textColor }};">
        <span>
            {{ $shortcode->text }}&nbsp;&nbsp;&nbsp;
        </span>
        <span>
            {{ $shortcode->text }}&nbsp;&nbsp;&nbsp;
        </span>
    </div>
</div>