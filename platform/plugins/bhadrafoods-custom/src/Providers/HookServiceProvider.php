<?php

namespace BhadraFoods\Custom\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\Fields\ShortcodeTagsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use BhadraFoods\Custom\Forms\ShortcodeBulkOrderAdminConfigForm;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function (string $template): string {
            return Theme::getThemeName() === 'ninico'
                ? 'plugins/bhadrafoods-custom::simple-slider'
                : $template;
        }, 99);

        if (! function_exists('shortcode')) {
            return;
        }

        add_shortcode(
            'bulk-order-form',
            __('Bulk Order Form'),
            __('B2B / bulk order enquiry form'),
            function (ShortcodeCompiler $shortcode) {
                Theme::asset()
                    ->usePath(false)
                    ->add('contact-css', asset('vendor/core/plugins/contact/css/contact-public.css'), [], [], '1.0.2');

                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add('contact-public-js', asset('vendor/core/plugins/contact/js/contact-public.js'), ['jquery'], [], '1.0.1');

                $products = is_plugin_active('ecommerce')
                    ? Product::query()->wherePublished()->orderBy('name')->pluck('name', 'id')->all()
                    : [];

                return view('plugins/bhadrafoods-custom::bulk-order-form', compact('shortcode', 'products'));
            }
        );

        shortcode()->setAdminConfig('bulk-order-form', fn (array $attributes) =>
            ShortcodeBulkOrderAdminConfigForm::createFromArray($attributes)
        );

        shortcode()->ignoreLazyLoading(['bulk-order-form']);
        shortcode()->ignoreCaches(['bulk-order-form']);

        if (is_plugin_active('ecommerce')) {
            Shortcode::register('product-categories', __('Product Categories'), __('Product Categories'), function (ShortcodeCompiler $shortcode) {
                $categoryIds = Shortcode::fields()->getIds('category_ids', $shortcode);

                if (! $categoryIds) {
                    return null;
                }

                $categories = ProductCategory::query()
                    ->whereIn('id', $categoryIds)
                    ->wherePublished()
                    ->with('slugable')
                    ->withCount('products')
                    ->orderBy('order')
                    ->orderByDesc('created_at')
                    ->get();

                if ($categories->isEmpty()) {
                    return null;
                }

                $style = in_array($shortcode->style, ['wooden', 'fashion', 'cosmetics', 'custom'], true)
                    ? $shortcode->style
                    : 'wooden';

                if ($style === 'custom') {
                    return view('plugins/bhadrafoods-custom::shortcodes.product-categories.custom', compact('shortcode', 'categories'));
                }

                return Theme::partial("shortcodes.product-categories.styles.$style", compact('shortcode', 'categories'));
            });

            Shortcode::setAdminConfig('product-categories', function (array $attributes) {
                return ShortcodeForm::createFromArray($attributes)
                    ->withLazyLoading()
                    ->add('title', 'text', [
                        'label' => __('Title'),
                        'help_block' => ['text' => __('Wrapper text into <code>:tag</code> tag to make it highlight.', ['tag' => '&lt;span&gt;text&lt;/span&gt;'])],
                    ])
                    ->add('subtitle', 'text', [
                        'label' => __('Subtitle'),
                        'help_block' => ['text' => __('Only work in custom style', ['tag' => '&lt;span&gt;text&lt;/span&gt;'])],
                    ])
                    ->add('category_ids', ShortcodeTagsField::class, [
                        'label' => __('Categories'),
                        'attr' => ['placeholder' => __('Choose categories')],
                        'choices' => ProductCategory::query()->wherePublished()->pluck('name', 'id')->all(),
                    ])
                    ->add('style', 'customSelect', [
                        'label' => __('Style'),
                        'choices' => [
                            'wooden' => __('Wooden'),
                            'fashion' => __('Fashion'),
                            'cosmetics' => __('Cosmetics'),
                            'custom' => __('Custom'),
                        ],
                    ]);
            });
        }

        Shortcode::register('about2', __('About 2'), __('About 2'), fn (ShortcodeCompiler $shortcode) =>
            view('plugins/bhadrafoods-custom::shortcodes.about2.index', compact('shortcode'))
        );
        Shortcode::setAdminConfig('about2', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)->withLazyLoading()->columns()
                ->add('image_1', 'mediaImage', ['label' => __('Main Image'), 'colspan' => 2])
                ->add('image_2', 'mediaImage', ['label' => __('Bottom Image'), 'colspan' => 2])
                ->add('logo', 'mediaImage', ['label' => __('Center Logo'), 'colspan' => 2])
                ->add('subtitle', 'text', ['label' => __('Small Badge Title'), 'colspan' => 2])
                ->add('title', 'text', ['label' => __('Main Title'), 'colspan' => 2])
                ->add('description', 'textarea', ['label' => __('Main Description'), 'attr' => ['rows' => 4], 'colspan' => 2])
                ->add('feature_title_1', 'text', ['label' => __('Feature Title 1'), 'colspan' => 2])
                ->add('feature_text_1', 'textarea', ['label' => __('Feature Description 1'), 'attr' => ['rows' => 3], 'colspan' => 2])
                ->add('feature_title_2', 'text', ['label' => __('Feature Title 2'), 'colspan' => 2])
                ->add('feature_text_2', 'textarea', ['label' => __('Feature Description 2'), 'attr' => ['rows' => 3], 'colspan' => 2]);
        });

        Shortcode::register('why-choose', __('Why Choose Us'), __('Why Choose Us'), fn (ShortcodeCompiler $shortcode) =>
            view('plugins/bhadrafoods-custom::shortcodes.why-choose.index', compact('shortcode'))
        );
        Shortcode::setAdminConfig('why-choose', function (array $attributes) {
            $form = ShortcodeForm::createFromArray($attributes)->withLazyLoading()->columns()
                ->add('title', 'text', ['label' => __('Main Title'), 'colspan' => 2])
                ->add('subtitle', 'text', ['label' => __('Sub Title'), 'colspan' => 2])
                ->add('image_1', 'mediaImage', ['label' => __('Main Image'), 'colspan' => 2])
                ->add('image_2', 'mediaImage', ['label' => __('Bottom Image'), 'colspan' => 2])
                ->add('description', 'textarea', ['label' => __('Description'), 'attr' => ['rows' => 4], 'colspan' => 2]);

            foreach ([1, 2, 3, 4] as $number) {
                $form->add("feature_title_$number", 'text', ['label' => __('Feature Title ') . $number, 'colspan' => 2]);

                if ($number > 2) {
                    $form->add("feature_text_$number", 'textarea', ['label' => __('Feature Description ') . $number, 'attr' => ['rows' => 3], 'colspan' => 2]);
                }
            }

            foreach ([1, 2, 3, 4, 5] as $number) {
                $form->add("counter_title_$number", 'text', ['label' => __('Counter Title ') . $number, 'colspan' => 2])
                    ->add("counter_value_$number", 'text', ['label' => __('Counter Value ') . $number, 'colspan' => 2]);
            }

            return $form;
        });

        Shortcode::register('marquee', __('Marquee Strip'), __('Moving text strip'), fn (ShortcodeCompiler $shortcode) =>
            view('plugins/bhadrafoods-custom::shortcodes.marquee.index', compact('shortcode'))
        );
        Shortcode::setAdminConfig('marquee', function (array $attributes) {
            $form = ShortcodeForm::createFromArray($attributes);

            for ($number = 1; $number <= 6; $number++) {
                $form->add($number === 1 ? 'feature' : 'feature' . $number, 'text', [
                    'label' => __('Feature text') . ($number > 1 ? ' ' . $number : ''),
                ]);
            }

            return $form;
        });
    }
}
