<?php

namespace BhadraFoods\Custom\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Event;

class BhadraFoodsCustomServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/bhadrafoods-custom')
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->publishAssets();

        $this->loadJsonTranslationsFrom($this->getPath('/resources/lang'));

        $this->app->booted(function (): void {
            $this->app->register(HookServiceProvider::class);
        });

        Event::listen('theme.beforeRenderTheme', function (): void {
            if (Theme::getThemeName() !== 'ninico') {
                return;
            }

            Theme::asset()
                ->usePath(false)
                ->add('bhadrafoods-custom-css', asset('vendor/core/plugins/bhadrafoods-custom/css/custom.css'));
        });
    }
}
