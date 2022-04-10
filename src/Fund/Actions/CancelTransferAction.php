<?php

namespace App\Fund\Actions;

use App\Fund\FundService;
use Psr\Http\Message\ServerRequestInterface;

class CancelTransferAction extends \ClientX\Actions\Action
{
    private FundService $service;

    public function __construct(FundService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $this->service->cancel($id);
        return $this->back($request);
    }
}