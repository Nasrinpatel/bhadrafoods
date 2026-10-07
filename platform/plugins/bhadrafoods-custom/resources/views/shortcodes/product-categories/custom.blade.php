<div class="our-products">
    <div class="container">
        <div class="row section-row align-items-center">
            <div class="col-lg-12">
                <div class="section-title section-title-center">
                    <h3 class="wow fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">
                        {!! BaseHelper::clean($shortcode->subtitle) !!}
                    </h2>
                </div>
            </div>
        </div>

        <div class="row product-item-list">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-6">
                    <div class="product-item wow fadeInUp">
                        <div class="product-image">
                            <figure>
                                <img src="{{ RvMedia::getImageUrl($category->image, default: RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                            </figure>
                            <div class="product-cart-btn">
                                <a href="{{ $category->url }}">View Products</a>
                            </div>
                        </div>
                        <div class="product-item-body">
                            <h3>{{ $category->name }}</h3>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
