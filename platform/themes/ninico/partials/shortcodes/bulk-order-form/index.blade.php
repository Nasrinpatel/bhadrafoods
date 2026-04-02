<section class="contact-area mb-40">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-12">
            <div class="tpcontact__form">
                <div class="tpcontact__info mb-35 text-center">
                    <h4 class="tpcontact__title">{!! BaseHelper::clean($shortcode->form_title ?: __('B2B / Bulk Order Enquiry')) !!}</h4>
                    <p>{!! BaseHelper::clean($shortcode->form_subtitle ?: __('Share your product requirements and our team will get back with pricing, MOQ details, and next steps.')) !!}</p>
                </div>

                <form action="{{ route('public.bulk-order.send') }}" method="POST" class="contact-form">
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
                                <label class="contact-label required" for="bulk-order-products">{{ __('Product List') }}</label>
                                <textarea id="bulk-order-products" name="product_list" class="contact-form-input" rows="4" placeholder="{{ __('List the products you want to order') }}" required></textarea>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
                                <label class="contact-label required" for="bulk-order-quantity">{{ __('Qty in KG') }}</label>
                                <input id="bulk-order-quantity" type="text" name="quantity_in_kg" class="contact-form-input" placeholder="{{ __('Example: 100 kg') }}" required>

                                @if ($moqNote = $shortcode->moq_note ?: __('Minimum order quantity (MOQ) applies.'))
                                    <small class="d-block mt-2 text-muted">{{ $moqNote }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
                                <label class="contact-label" for="bulk-order-message">{{ __('Message / Comment') }}</label>
                                <textarea id="bulk-order-message" name="content" class="contact-form-input" rows="6" placeholder="{{ __('Tell us about packaging, delivery location, timelines, or any special requirement') }}" required></textarea>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
                                <div class="contact-message contact-success-message" style="display: none"></div>
                                <div class="contact-message contact-error-message" style="display: none"></div>
                            </div>
                        </div>

                        <div class="contact-column-12">
                            <div class="contact-form-group">
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
