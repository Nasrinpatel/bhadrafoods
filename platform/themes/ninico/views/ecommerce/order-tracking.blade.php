@php
    Theme::set('pageTitle', __('Track Your Order'));

    // Match the submit button styling used by the theme's other front forms.
    $form->modify('submit', 'submit', [
        'attr' => [
            'class' => 'tptrack__submition',
        ],
    ]);
@endphp

<div class="track-area">
    @include('plugins/ecommerce::themes.order-tracking')
</div>
