<?php
namespace App\Fund;

use App\Shop\Payment\RedirectUriPaymentInterface;
use ClientX\Router;
use Psr\Http\Message\ServerRequestInterface;

class FundRedirectUri implements RedirectUriPaymentInterface
{


    public function makeReturn(Router $router, ServerRequestInterface $request, int $id, string $type)
    {
        return $router->generateURI("fund.redirect.return", compact('id', 'type'));
    }

    public function makeCancel(Router $router, ServerRequestInterface $request, int $id, string $type)
    {
        return $router->generateURI("fund.redirect.cancel", compact('id', 'type'));
    }
}
