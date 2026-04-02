<?php

namespace Theme\Ninico\Forms;

use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Forms\ShortcodeForm;

class ShortcodeBulkOrderAdminConfigForm extends ShortcodeForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->add(
                'form_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Form title'))
                    ->toArray()
            )
            ->add(
                'form_subtitle',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Form subtitle'))
                    ->toArray()
            )
            ->add(
                'minimum_order_quantity',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(__('Minimum order quantity (kg)'))
                    ->defaultValue(10)
                    ->helperText(__('Example: 10 will show "Minimum 10kg" and enforce quantity starting from 10kg.'))
                    ->toArray()
            )
            ->add(
                'button_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Button label'))
                    ->toArray()
            );
    }
}
