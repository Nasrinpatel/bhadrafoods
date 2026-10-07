<div class="about-us" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <!-- About Image Box Start -->
                <div class="about-image-box">
                    <!-- About Image Start -->
                    <div class="about-image">
                        <figure class="image-anime reveal">
                            <img src="{{ RvMedia::getImageUrl($shortcode->image_1, default: RvMedia::getDefaultImage()) }}" alt="{{ $shortcode->title }}">
                        </figure>

                        <!-- Contact Us Circle Start -->
                        @if($shortcode->logo)
                            <div class="contact-us-circle">
                                <a href="#contact"><img src="{{ RvMedia::getImageUrl($shortcode->logo) }}" alt=""></a>
                            </div>
                        @endif
                        <!-- Contact Us Circle End -->
                    </div>
                    <!-- About Image End -->

                    <!-- About Image Item Box Start -->
                    <div class="about-image-item-box">
                        <!-- About Image Item Start -->
                        <div class="about-image-item">
                            <div class="icon-box">
                                <img src="../../../storage/icons/icon-about-image-item.svg" alt="">
                            </div>
                            <div class="about-image-item-content">
                                <h2><span class="counter">98</span>%</h2>
                                <h3>Satisfaction Rate</h3>
                            </div>
                        </div>
                        <!-- About Image Item End -->

                        <!-- About Image Start -->
                        <div class="about-image">
                            <figure class="image-anime reveal">
                                <img src="{{ RvMedia::getImageUrl($shortcode->image_2, default: RvMedia::getDefaultImage()) }}" alt="{{ $shortcode->title }}">
                            </figure>
                        </div>
                        <!-- About Image End -->
                    </div>
                    <!-- About Image Item Box End -->
                </div>
                <!-- About Image Box End -->
            </div>

            <div class="col-lg-6">
                <!-- About us Content Start -->
                <div class="about-us-content">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        @if($shortcode->subtitle)
                            <h3 class="wow fadeInUp">{{ $shortcode->subtitle }}</h3>
                        @endif
                        @if($shortcode->title)
                            <h2 class="text-anime-style-3" data-cursor="-opaque">
                                {{ $shortcode->title }}
                            </h2>
                        @endif
                        @if($shortcode->description)
                            <p class="wow fadeInUp" data-wow-delay="0.2s">
                                {{ $shortcode->description }}
                            </p>
                        @endif
                    </div>
                    <!-- Section Title End -->

                    <!-- About Us Body Start -->
                    <div class="about-us-body wow fadeInUp" data-wow-delay="0.4s">
                        <!-- About Body Item Start -->
                        <div class="about-body-item active">
                            <div class="icon-box">
                                <img src="../../../storage/icons/icon-about-body-1.svg" alt="">
                            </div>
                            <div class="about-body-content">
                                @if($shortcode->feature_title_1)
                                    <h3>{{ $shortcode->feature_title_1 }}</h3>
                                    <p>
                                        {{ $shortcode->feature_text_1 }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <!-- About Body Item End -->

                        <!-- About Body Item Start -->
                        <div class="about-body-item">
                            <div class="icon-box">
                                <img src="../../../storage/icons/icon-about-body-2.svg" alt="">
                            </div>
                            <div class="about-body-content">
                                @if($shortcode->feature_title_2)
                                    <h3>{{ $shortcode->feature_title_2 }}</h3>
                                    <p>
                                        {{ $shortcode->feature_text_2 }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <!-- About Body Item End -->
                    </div>
                    <!-- About Us Body End -->
                </div>
                <!-- About us Content End -->
            </div>
        </div>
    </div>
</div>
