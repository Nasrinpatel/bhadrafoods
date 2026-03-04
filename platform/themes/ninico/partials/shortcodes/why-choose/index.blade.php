<!-- Why Choose Us Section Start -->
<div class="why-choose-us">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <!-- Why Choose Content Start -->
                <div class="why-choose-content">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">{{ $shortcode->title ?? '' }}</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">
                            {{ $shortcode->subtitle ?? '' }}
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                            {{ $shortcode->description ?? '' }}
                        </p>
                    </div>
                    <!-- Section Title End -->

                    <!-- Why Choose List Start -->
                    <div class="why-choose-list wow fadeInUp" data-wow-delay="0.4s">
                        <ul>
                            <li>{{ $shortcode->feature_title_1 ?? 'Authentic Gujarati ready-to-eat snacks' }}</li>
                            <li>{{ $shortcode->feature_title_2 ?? 'Strict hygiene and quality standards' }}</li>
                        </ul>
                    </div>
                    <!-- Why Choose List End -->

                    <!-- Why Choose Body Start -->
                    <div class="why-choose-body">
                        <div class="why-choose-experience">
                            <h2><span class="counter">{{ $shortcode->counter_value_1 ?? 10 }}</span></h2>
                            <p>{{ $shortcode->counter_title_1 ?? 'Years of Snack Crafting' }}</p>
                        </div>

                        <div class="why-choose-item-list">
                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.6s">
                                <h3>{{ $shortcode->feature_title_3 ?? 'Consistent Quality' }}</h3>
                                <p>
                                    {{ $shortcode->feature_text_3 ?? 'Every batch of our snacks undergoes rigorous quality checks to ensure you get the same authentic taste and purity in every bite.' }}
                                </p>
                            </div>
                            <!-- Why Choose Item End -->

                            <!-- Why Choose Item Start -->
                            <div class="why-choose-item wow fadeInUp" data-wow-delay="0.8s">
                                <h3>{{ $shortcode->feature_title_4 ?? 'Perfect for Gifting' }}</h3>
                                <p>
                                    {{ $shortcode->feature_text_4 ?? 'Beautifully presented Celebration Boxes that make thoughtful gifts for festivals, corporate hampers and special occasions.' }}
                                </p>
                            </div>
                            <!-- Why Choose Item End -->
                        </div>
                    </div>
                    <!-- Why Choose Body End -->
                </div>
                <!-- Why Choose Content End -->
            </div>

            <div class="col-lg-6">
                <!-- Why Choose Image Start -->
                <div class="why-choose-image">
                    <div class="why-choose-img-1">
                        <figure>
                            <img src="{{ RvMedia::getImageUrl($shortcode->image_1 ?? null, default: RvMedia::getDefaultImage()) }}" alt="">
                        </figure>
                    </div>
                    <div class="why-choose-img-2">
                        <figure>
                            <img src="{{ RvMedia::getImageUrl($shortcode->image_2 ?? null, default: RvMedia::getDefaultImage()) }}" alt="">
                        </figure>
                    </div>
                </div>
                <!-- Why Choose Image End -->
            </div>

            <div class="col-lg-12">
                <!-- Why Choose Counter List Start -->
                <div class="why-choose-counter-list wow fadeInUp">
                    <!-- Why Choose Counter Item Start -->
                    <div class="why-choose-counter-item">
                        <h2><span class="counter">{{ $shortcode->counter_value_2 ?? 98 }}</span></h2>
                        <p>{{ $shortcode->counter_title_2 ?? 'Happy Customers' }}</p>
                    </div>
                    <!-- Why Choose Counter Item End -->

                    <!-- Why Choose Counter Item Start -->
                    <div class="why-choose-counter-item">
                        <h2><span class="counter">{{ $shortcode->counter_value_3 ?? 100 }}</span></h2>
                        <p>{{ $shortcode->counter_title_3 ?? 'Focus on Purity' }}</p>
                    </div>
                    <!-- Why Choose Counter Item End -->

                    <!-- Why Choose Counter Item Start -->
                    <div class="why-choose-counter-item">
                        <h2><span class="counter">{{ $shortcode->counter_value_4 ?? 3 }}</span></h2>
                        <p>{{ $shortcode->counter_title_4 ?? 'Signature Celebration Boxes' }}</p>
                    </div>
                    <!-- Why Choose Counter Item End -->

                    <!-- Why Choose Counter Item Start -->
                    <div class="why-choose-counter-item">
                        <h2><span class="counter">{{ $shortcode->counter_value_5 ?? 20 }}</span></h2>
                        <p>{{ $shortcode->counter_title_5 ?? 'Snack Variants Inside' }}</p>
                    </div>
                    <!-- Why Choose Counter Item End -->
                </div>
                <!-- Why Choose Counter List End -->
            </div>
        </div>
    </div>
</div>
<!-- Why Choose Us Section End -->
