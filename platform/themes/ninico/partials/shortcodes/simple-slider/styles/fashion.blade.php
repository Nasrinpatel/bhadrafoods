<div class="slider-pagination-2 p-relative">
    <div class="swiper-containers slidertwo-active">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide slider-bg"
                    style="background-image: url('{{ RvMedia::getImageUrl($slider->image) }}');
                            background-size: cover;
                            background-position: center;">

                    <div class="slider-content-wrapper">
                        <div class="container">
                            <div class="slider-top-padding pt-120 pb-120">
                                <div class="tpslidertwo__item">
                                    <div class="tpslidertwo__content text-white">

                                        @if($subtitle = $slider->getMetaData('subtitle', true))
                                            <h4 class="tpslidertwo__sub-title text-white">
                                                {!! BaseHelper::clean($subtitle) !!}
                                            </h4>
                                        @endif

                                        @if($slider->title)
                                            <h3 class="tpslidertwo__title mb-10 text-white">
                                                {!! BaseHelper::clean($slider->title) !!}
                                            </h3>
                                        @endif

                                        @if($description = $slider->description)
                                            <div class="text-white">
                                                {!! BaseHelper::clean($description) !!}
                                            </div>
                                        @endif

                                        @if(($actionLabel = $slider->getMetaData('action_label', true)) && $slider->link)
                                            <div class="tpslidertwo__slide-btn mt-20">
                                                <a class="tp-btn banner-animation" href="{{ $slider->link }}">
                                                    {{ $actionLabel }}
                                                    <i class="fal fa-long-arrow-right"></i>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
    <div class="slider-two-pagination">
        <div class="container">
            <div class="slider-two-pagination-item p-relative">
                <div class="slidertwo_pagination"></div>
            </div>
        </div>
    </div>
</div>

