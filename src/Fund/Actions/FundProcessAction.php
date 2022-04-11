<?php

namespace App\Fund\Actions;

use App\Fund\AddFund;
use App\Fund\FundRedirectUri;
use App\Shop\Entity\Transaction;
use App\Shop\Services\TransactionService;
use ClientX\Actions\Action;
use ClientX\Auth;
use ClientX\Database\Query;
use ClientX\Payment\PaymentManager;
use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class FundProcessAction extends Action
{

    private TransactionService $transaction;
    private PaymentManager $manager;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(
        PaymentManager $paymentManager,
        Auth $auth,
        TransactionService $transaction,
        LoggerInterface $logger
    ) {
        $this->manager = $paymentManager;
        $this->transaction = $transaction;
        $this->auth = $auth;
        $this->transaction->setRedirect(new FundRedirectUri());
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
        if (empty($this->manager->getTypes())) {
            return $this->back($request);
        }
        $paymentType = $this->manager->getFromName($params['type'] ?? "wallet");
        try {
            $user = $this->getUser();
            (new Query($this->transaction->getTable()->getConnection()))
                ->setCommand("INSERT")
                ->from("fund_transactions")
                ->params(['user_id' => $this->getUserId(), 'amount' => (float)$params['amount']])
                ->execute();
            $id = $this->transaction->getTable()->getConnection()->lastInsertId();
            $orderable = new AddFund((float)$params['amount'], $this->getUserId(), $this->transaction->getCurrency(), $id);

            return $this->transaction->processFromOrderable($orderable, $user, $paymentType, $request);
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
            return new Response(500);
        }
    }
}
