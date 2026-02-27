<section class="about-area pt-80 pb-80">
    <div class="container">
        <div class="row align-items-center">

            <!-- LEFT IMAGE SECTION -->
            <div class="col-lg-5">
                <div class="about-image-wrapper position-relative">

                    <!-- Main Big Image -->
                    <div class="about-main-img mb-4">
                        <img class="w-100 rounded"
                             src="{{ RvMedia::getImageUrl($shortcode->image_1, default: RvMedia::getDefaultImage()) }}"
                             alt="{{ $shortcode->title }}">
                    </div>

                    <div class="row">

                        <!-- 98% Box -->
                        <div class="col-6">
                            <div class="about-satisfaction text-center">
                               
                                <h2>98%</h2><br>
                                <p>Satisfaction Rate</p>
                            </div>
                        </div>

                        <!-- Bottom Small Image -->
                        <div class="col-6">
                            <div class="about-small-img">
                                <img class="w-100 rounded"
                                     src="{{ RvMedia::getImageUrl($shortcode->image_2, default: RvMedia::getDefaultImage()) }}"
                                     alt="{{ $shortcode->title }}">
                            </div>
                        </div>
                    </div>

                    <!-- Center Logo -->
                    @if($shortcode->logo)
                        <div class="about-center-logo">
                            <img src="{{ RvMedia::getImageUrl($shortcode->logo) }}"
                                 alt="{{ $shortcode->title }}">
                        </div>
                    @endif

                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="col-lg-7">
                <div class="about-content ps-4">

                    @if($shortcode->subtitle)
                        <span class="about-badge">{{ $shortcode->subtitle }}</span>
                    @endif

                    @if($shortcode->title)
                        <h2 class="about-title mt-3">
                            {{ $shortcode->title }}
                        </h2>
                    @endif

                    @if($shortcode->description)
                        <p class="about-desc mt-3">
                            {{ $shortcode->description }}
                        </p>
                    @endif

                    @if($shortcode->feature_title_1)
                        <div class="about-feature about-title mt-4">
                            <h5>{{ $shortcode->feature_title_1 }}</h5>
                            <p>{{ $shortcode->feature_text_1 }}</p>
                        </div>
                    @endif

                    @if($shortcode->feature_title_2)
                        <div class="about-feature about-title mt-4">
                            <h5>{{ $shortcode->feature_title_2 }}</h5>
                            <p>{{ $shortcode->feature_text_2 }}</p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>