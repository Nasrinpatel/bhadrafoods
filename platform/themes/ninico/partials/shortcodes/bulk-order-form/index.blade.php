<section class="contact-area mb-40 bulk-order-section">
    @php
        $minimumOrderQuantity = max((float) ($shortcode->minimum_order_quantity ?: 10), 1);
        $minimumOrderQuantityLabel = rtrim(rtrim(number_format($minimumOrderQuantity, 2, '.', ''), '0'), '.');
    @endphp

    <div class="row justify-content-center">
        <div class="col-lg-10 col-12">
            <div class="tpcontact__form bulk-order-form-wrap">
                <div class="tpcontact__info mb-35 text-center">
                    <h4 class="tpcontact__title">{!! BaseHelper::clean($shortcode->form_title ?: __('B2B / Bulk Order Enquiry')) !!}</h4>
                    <p>{!! BaseHelper::clean($shortcode->form_subtitle ?: __('Share your product requirements and our team will get back with pricing, MOQ details, and next steps.')) !!}</p>
                </div>

                <form action="{{ route('public.bulk-order.send') }}" method="POST" class="contact-form bulk-order-form">
                    @csrf

                    <div class="contact-form-row">
                        <div class="contact-column-6">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-name">{{ __('Name') }}</label>
                                <input id="bulk-order-name" type="text" name="name" class="contact-form-input" placeholder="{{ __('Your name') }}" required>
                            </div>
                        </div>

                        <div class="contact-column-6">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-company">{{ __('Company Name') }}</label>
                                <input id="bulk-order-company" type="text" name="company_name" class="contact-form-input" placeholder="{{ __('Company name') }}" required>
                            </div>
                        </div>

                        <div class="contact-column-6">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-phone">{{ __('Phone') }}</label>
                                <input id="bulk-order-phone" type="text" name="phone" class="contact-form-input" placeholder="{{ __('Phone number') }}" required>
                            </div>
                        </div>

                        <div class="contact-column-6">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-email">{{ __('Email') }}</label>
                                <input id="bulk-order-email" type="email" name="email" class="contact-form-input" placeholder="{{ __('Email address') }}" required>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-products">{{ __('Product') }}</label>
                                <select id="bulk-order-products" name="product_id" class="contact-form-input" required>
                                    <option value="">{{ __('Select a product') }}</option>
                                    @foreach ($products as $productId => $productName)
                                        <option value="{{ $productId }}">{{ $productName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-quantity">{{ __('Qty in KG') }}</label>
                                <input type="hidden" name="minimum_order_quantity" value="{{ $minimumOrderQuantity }}">
                                <input id="bulk-order-quantity" type="number" name="quantity_in_kg" class="contact-form-input" min="{{ $minimumOrderQuantity }}" step="0.01" placeholder="{{ __('Enter quantity in kg') }}" required>
                                <small class="d-block mt-2 text-muted">{{ __('Minimum :qtykg', ['qty' => $minimumOrderQuantityLabel]) }}</small>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-message">{{ __('Message / Comment') }}</label>
                                <textarea id="bulk-order-message" name="content" class="contact-form-input bulk-order-message" rows="6" placeholder="{{ __('Tell us about packaging, delivery location, timelines, or any special requirement') }}" required></textarea>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
                                <div class="contact-message contact-success-message" style="display: none"></div>
                                <div class="contact-message contact-error-message" style="display: none"></div>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group bulk-order-submit">
                                <button type="submit" class="tp-btn tp-color-btn tp-wish-cart">
                                    {{ $shortcode->button_label ?: __('Send Bulk Order Request') }}
                                    <i class="fal fa-long-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
