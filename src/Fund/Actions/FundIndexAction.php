<?php
namespace App\Fund\Actions;

use App\Fund\FundService;
use ClientX\Actions\Action;
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
        $transfers = $this->service->findForUser();
        return $this->render('@fund/index', ['types' => $this->types,'transfers' => $transfers, 'errors' => $errors]);
    }
}
