<?php

namespace App\Fund\Actions;

use App\Fund\FundService;
use ClientX\Actions\Action;
use Psr\Http\Message\ServerRequestInterface;

class FundTransferAction extends Action
{

    private FundService $service;
    private bool $enabletransfer;

    public function __construct(FundService $service, string $enabletransfer)
    {
        $this->service = $service;
        $this->enabletransfer = $enabletransfer == 'true';
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if (!$this->enabletransfer) {
            return new \GuzzleHttp\Psr7\Response(404);
        }
        $params = $request->getParsedBody();
        $validator = $this->service->validate($params);
        if ($validator->isValid()) {
            $this->service->add($params['email'], $params['amount']);
            return $this->back($request);
        }
        $errors = $validator->getErrors();
        $this->service->saveErrors($errors);
        return $this->back($request);
    }
}
