<ol>
    <li>
        <p>
            <a href="https://developer.phonepe.com/payment-gateway" target="_blank">
                {{ __('Create or open your PhonePe Payment Gateway merchant account') }}
            </a>
        </p>
    </li>
    <li>
        <p>{{ __('Collect your Client ID, Client Secret, and Client Version from PhonePe Standard Checkout.') }}</p>
    </li>
    <li>
        <p>{{ __('Set the redirect URL in PhonePe to :url', ['url' => route('payment.phonepe-v2.callback', ['trans_id' => 'ORDER_ID'])]) }}</p>
    </li>
    <li>
        <p>{{ __('Set the server callback/webhook URL in PhonePe to :url', ['url' => route('payment.phonepe-v2.webhook')]) }}</p>
    </li>
    <li>
        <p>{{ __('Use the same callback username and password here that you configure in PhonePe for webhook verification.') }}</p>
    </li>
</ol>
