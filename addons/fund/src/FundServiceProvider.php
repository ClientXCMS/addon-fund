<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund;

use App\Addons\Fund\Http\Controllers\FundAdminController;
use App\Addons\Fund\Listeners\AddFundInvoiceCompletedListener;
use App\Events\Core\Invoice\InvoiceCompleted;
use App\Extensions\BaseAddonServiceProvider;
use App\Models\Admin\Permission;
use Illuminate\Console\Scheduling\Schedule;

class FundServiceProvider extends BaseAddonServiceProvider
{
    protected string $uuid = 'fund';

    public function register()
    {
        \Event::listen(InvoiceCompleted::class, AddFundInvoiceCompletedListener::class);
        $this->registerSchedule();
        $this->commands([
            \App\Addons\Fund\Commands\FundCommand::class,
        ]);
    }

    public function schedule(Schedule $schedule): void
    {
        if ($this->app->runningInConsole()) {
            $schedule->command('fund:transfer')->everyMinute()
                ->name('fund:transfer')
                ->sendOutputTo(storage_path('logs/fund_transfer.log'))
                ->evenInMaintenanceMode();
        }
    }

    public function boot()
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadMigrations();
        \Route::middleware(['web', 'admin'])->prefix(admin_prefix('fund'))->name('admin.fund.')->group(function () {
            require addon_path('fund', 'routes/admin.php');
        });
        \Route::middleware(['web'])->prefix('fund')->name('fund.')->group(function () {
            require addon_path('fund', 'routes/web.php');
        });
        $settings = $this->app->make('settings');
        $settings->addCardItem('extensions', 'fund', 'fund::messages.admin.settings.title', 'fund::messages.admin.settings.subtitle', 'bi bi-cash-coin', [FundAdminController::class, 'settings'], Permission::MANAGE_EXTENSIONS);
        $settings->addCardItem('extensions', 'fund_transfers', 'fund::messages.admin.transfers.title', 'fund::messages.admin.transfers.subtitle', 'bi bi-cash-coin', [FundAdminController::class, 'transfers'], Permission::MANAGE_EXTENSIONS);
    }
}
