<?php

namespace App\Fund;

use App\Admin\Database\SettingTable;
use App\Fund\Actions\CancelTransferAction;
use App\Fund\Actions\FundCancelAction;
use App\Fund\Actions\FundIndexAction;
use App\Fund\Actions\FundProcessAction;
use App\Fund\Actions\FundReturnAction;
use App\Fund\Actions\FundTransferAction;
use ClientX\Module;
use ClientX\Renderer\RendererInterface;
use ClientX\Router;
use ClientX\Theme\ThemeInterface;
use Psr\Container\ContainerInterface;

class FundModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    const TRANSLATIONS = [
        "fr_FR" => __DIR__ . "/trans/fr.php",
        "en_GB" => __DIR__ . "/trans/en.php",
        "uk_UA" => __DIR__ . "/trans/ua.php",
        "es_ES" => __DIR__ . "/trans/es.php",
        "ja_JP" => __DIR__ . "/trans/ja.php",
        "de_DE" => __DIR__ . "/trans/de.php"
    ];
    const MIGRATIONS = __DIR__ . '/db/migrations';

    public function __construct(ContainerInterface $container, ThemeInterface $theme, SettingTable $table)
    {
        $renderer = $container->get(RendererInterface::class);
        $renderer->addPath('fund', $theme->getViewsPath() . '/Fund');
        $renderer->addPath('fund_admin', __DIR__. '/Views');
        $router = $container->get(Router::class);
        /** @var string */
        $prefix = $container->get('clientarea.prefix');
        $router->get($prefix . '/fund', FundIndexAction::class, 'fund.index');
        $router->any($prefix . '/fund/process', FundProcessAction::class, 'fund.redirect.process');
        $router->any($prefix . '/fund/[i:id]/cancel', FundCancelAction::class, 'fund.redirect.cancel');
        $router->any($prefix . '/fund/[i:id]/return', FundReturnAction::class, 'fund.redirect.return');
        $router->get($prefix . '/cancel/[i:id]', CancelTransferAction::class, 'fund.cancel');
        $router->post($prefix . '/fund/transfer', FundTransferAction::class, 'fund.transfer');
    }
}
