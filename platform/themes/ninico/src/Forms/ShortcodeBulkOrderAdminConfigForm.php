<?php

namespace Theme\Ninico\Forms;

use Botble\Base\Forms\FieldOptions\TextFieldOption;
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
                'moq_note',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('MOQ note'))
                    ->helperText(__('Shown below the quantity field.'))
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
