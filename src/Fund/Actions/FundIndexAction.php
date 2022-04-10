<?php
namespace App\Fund\Actions;

use App\Fund\FundService;
use ClientX\Actions\Action;
use ClientX\Database\Query;
use ClientX\Payment\PaymentManager;
use ClientX\Payment\PaymentTypeInterface;
use ClientX\Renderer\RendererInterface;

class FundIndexAction extends Action
{

    private array $types;
    /**
     * @var \App\Fund\FundService
     */
    private FundService $service;

    public function __construct(RendererInterface $renderer, PaymentManager $manager, FundService $service)
    {
        $this->renderer = $renderer;
        $this->types = collect($manager->getTypesCanPayWith())->filter(function (PaymentTypeInterface $type) {
            return $type->getName() != 'wallet';
        })->toArray();
        $this->service = $service;
    }

    public function __invoke()
    {
        $this->service->makeTransfers(true);


        $errors = $this->service->getErrors();
        $transfers = $this->service->findForUser()->fetchAll();

        $addMoney = (new Query($this->service->getTransferTable()->getConnection()))
            ->setCommand("SELECT")
            ->into(\stdClass::class)
            ->from("fund_transactions")
            ->where("user_id = :user_id")
            ->params(['user_id' => $this->service->getUserId()])
            ->fetchAll();
        return $this->render('@fund/index', ['types' => $this->types,'transfers' => $transfers, 'errors' => $errors, 'addMoney' => $addMoney]);
    }
}
