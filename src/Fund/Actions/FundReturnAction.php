<?php

namespace App\Fund\Actions;

use App\Basket\BasketRedirectUri;
use App\Fund\FundRedirectUri;
use App\Fund\FundService;
use App\Shop\Services\TransactionService;
use ClientX\Actions\Action;
use ClientX\Auth;
use ClientX\Payment\PaymentManager;
use ClientX\Renderer\RendererInterface;
use ClientX\Router;
use ClientX\Session\FlashService;
use ClientX\Translator\Translater;
use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class FundReturnAction extends Action
{

    protected LoggerInterface $logger;
    protected FundService $service;
    /**
     * @var \App\Shop\Services\TransactionService
     */
    private TransactionService $transactionService;
    /**
     * @var \ClientX\Payment\PaymentManager
     */
    private PaymentManager $purchaseProduct;
    protected $redirect = FundRedirectUri::class;


    public function __construct(
        RendererInterface  $renderer,
        FundService        $service,
        Auth               $auth,
        Router             $router,
        Translater         $translater,
        FlashService       $flash,
        LoggerInterface    $logger,
        TransactionService $transactionService,
        PaymentManager $purchaseProduct

    ) {
        $this->renderer = $renderer;
        $this->auth         = $auth;
        $this->service      = $service;
        $this->logger       = $logger;
        $this->translater   = $translater;
        $this->flash        = $flash;
        $this->router       = $router;
        $this->transactionService = $transactionService;
        $this->purchaseProduct = $purchaseProduct;
        $this->transactionService->setRedirect(new $this->redirect);
        $this->purchaseProduct->setRedirect(new $this->redirect);
    }

    public function __invoke(ServerRequestInterface $request)
    {
        try {
            $transaction = $this->transactionService->findTransaction($request->getAttribute('id'), $this->getUserId());
            if ($transaction != null && ($transaction->getState() === $transaction::PENDING || $transaction->getPaymentType() === 'stripe')) {
                $type = $this->purchaseProduct->getFromName($transaction->getPaymentType());
                $response = $this->purchaseProduct->execute($type, $transaction, $request, $this->getUser());
                $this->service->addFund($transaction);
                $this->transactionService->complete($transaction);
                $this->transactionService->delivre($transaction->getItems()[0]);
                $this->success($this->trans("serviceactions.transactions.success"));
            }

            return $this->redirectToRoute('fund.index');
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
            return new Response(500);
        }
    }
}
