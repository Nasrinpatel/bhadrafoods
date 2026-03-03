<!-- Hero Section Start -->
<div class="hero hero-slider-layout dark-section">
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <!-- Hero Slide Start -->
                <div class="swiper-slide">
                    <div class="hero-slide">
                        <!-- Slider Image Start -->
                        <div class="hero-slider-image">
                            @include(Theme::getThemeNamespace('partials.shortcodes.simple-slider.includes.image'))
                        </div>
                        <!-- Slider Image End -->

                        @if ($shortcode->show_slider_text)
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <!-- Hero Content Start -->
                                        <div class="hero-content">
                                            <!-- Section Title Start -->
                                            <div class="section-title">
                                                @if($slider->title)
                                                    <h3 class="wow fadeInUp">{!! BaseHelper::clean($slider->title) !!}</h3>
                                                @endif
                                                @if($subtitle = $slider->getMetaData('subtitle', true))
                                                    <h1 class="text-anime-style-3" data-cursor="-opaque">{!! BaseHelper::clean($subtitle) !!}</h1>
                                                @endif
                                                @if($slider->description)
                                                <p class="wow fadeInUp" data-wow-delay="0.2s">{!! BaseHelper::clean($slider->description) !!}</p>
                                                @endif
                                            </div>
                                            <!-- Section Title End -->


                                            <!-- Review Box Start -->
                                            <div class="review-box wow fadeInUp" data-wow-delay="0.6s">
                                                <!-- Review Images Start -->

                                                <!-- Review Images End -->

                                                <!-- Review Content Start -->
                                                {{-- <div class="satisfy-client-content">
                                                    <p>Beloved for their authentic Gujarati taste and consistent quality, Bhadra Foods Celebration Boxes are perfect for families, gifting, and festive moments.</p>
                                                </div> --}}
                                                <!-- Review Content End -->
                                            </div>
                                            <!-- Review Box Start -->
                                        </div>
                                        <!-- Hero Content End -->
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Hero Slide End -->
            @endforeach
        </div>
    </div>
</div>
<!-- Hero Section End -->
