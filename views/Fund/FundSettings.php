<?php

namespace App\Fund;

use ClientX\Renderer\RendererInterface;
use ClientX\Validator;

class FundSettings implements \App\Admin\Settings\SettingsInterface
{

    public function name(): string
    {
        return 'fund';
    }

    public function title(): string
    {
        return 'Fund';
    }

    public function icon(): string
    {
        return 'fas fa-dollar';
    }

    public function render(RendererInterface $renderer)
    {
        return $renderer->render('@fund_admin/settings');
    }

    public function validate(array $params): Validator
    {
        return (new Validator($params))
            ->integer('max_fund', 'min_fund', 'maxtransfer_fund', 'mintransfer_fund')
            ->min(1, 'max_fund', 'min_fund', 'maxtransfer_fund', 'mintransfer_fund');
    }
}