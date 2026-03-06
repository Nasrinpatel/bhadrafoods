<?php

namespace BhadraFoods\PhonePeV2\Forms;

use BhadraFoods\PhonePeV2\Facades\PhonePePayment;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\RadioFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\RadioField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Payment\Forms\PaymentMethodForm;

class PhonePePaymentMethodForm extends PaymentMethodForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->paymentId(PhonePePayment::getId())
            ->paymentName(PhonePePayment::getDisplayName())
            ->paymentDescription(__('Customer can buy product and pay using PhonePe Standard Checkout.'))
            ->paymentLogo(url('vendor/core/plugins/phonepe-v2/images/phonepe.png'))
            ->paymentUrl('https://www.phonepe.com')
            ->paymentInstructions(view('plugins/phonepe-v2::instructions')->render())
            ->add(
                get_payment_setting_key('client_id', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/phonepe-v2::phonepe.client_id'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('client_id', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('client_secret', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/phonepe-v2::phonepe.client_secret'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('client_secret', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('client_version', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/phonepe-v2::phonepe.client_version'))
                    ->value(get_payment_setting('client_version', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('callback_username', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/phonepe-v2::phonepe.callback_username'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('callback_username', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('callback_password', PhonePePayment::getId()),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/phonepe-v2::phonepe.callback_password'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('callback_password', PhonePePayment::getId()))
            )
            ->add(
                get_payment_setting_key('environment', PhonePePayment::getId()),
                RadioField::class,
                RadioFieldOption::make()
                    ->label(trans('plugins/phonepe-v2::phonepe.environment'))
                    ->choices([
                        'PRODUCTION' => trans('plugins/phonepe-v2::phonepe.production'),
                        'UAT' => trans('plugins/phonepe-v2::phonepe.testing'),
                    ])
                    ->selected(get_payment_setting('environment', PhonePePayment::getId(), 'UAT'))
            )
            ->add(
                get_payment_setting_key('should_publish_events', PhonePePayment::getId()),
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/phonepe-v2::phonepe.should_publish_events'))
                    ->value(get_payment_setting('should_publish_events', PhonePePayment::getId(), false))
            );
    }
}
