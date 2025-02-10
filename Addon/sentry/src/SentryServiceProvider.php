<?php

namespace App\Addons\Sentry;

use App\Addons\Sentry\Controllers\SentryController;
use \App\Extensions\BaseAddonServiceProvider;
use App\Services\SettingsService;

class SentryServiceProvider extends BaseAddonServiceProvider
{
  protected string $uuid = "sentry";

  public function register()
    {
    }

    public function boot()
    {
        $this->loadTranslations();
        $this->loadViews();

        \Route::middleware(['web', 'admin'])
            ->prefix(admin_prefix('settings/extensions'))
            ->name('admin.sentry.')
            ->group(function () {
                require addon_path('sentry', 'routes/admin.php');
            });
        /** @var SettingsService $settings */
        $settings = $this->app->make('settings');
        $settings->addCardItem('extensions', 'sentry', 'sentry::admin.title', 'sentry::admin.description', 'bi bi-shield-check', [SentryController::class, 'index']);

    }
}
