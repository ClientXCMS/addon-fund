<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('admin.settings.sidebar')
@section('title', __('fund::messages.admin.settings.title'))
@section('setting')
    <div class="card">
        <h4 class="font-semibold uppercase text-gray-600 dark:text-gray-400">
            {{ __('fund::messages.admin.settings.title') }}
        </h4>
        <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
            {{ __('fund::messages.admin.settings.subtitle') }}
        </p>

        <form action="{{ route('admin.fund.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3 class="font-semibold uppercase text-gray-600 dark:text-gray-400 col-span-2">{{ __('fund::messages.credit_title') }}</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    @include('admin/shared/input', ['name' => 'fund_credit_min_amount', 'label' => __('fund::messages.admin.settings.fields.min_amount'), 'value' => setting('fund_credit_min_amount', '5'), ['type' => 'number']])
                </div>
                <div>
                    @include('admin/shared/input', ['name' => 'fund_credit_max_amount', 'label' => __('fund::messages.admin.settings.fields.max_amount'), 'value' => setting('fund_credit_max_amount', '1000'), ['type' => 'number']])
                </div>
                <h3 class="font-semibold uppercase text-gray-600 dark:text-gray-400 col-span-2">{{ __('fund::messages.transfer_title') }}</h3>

                <div>
                    @include('admin/shared/checkbox', ['name' => 'fund_authorize_transfer_between_accounts', 'label' => __('fund::messages.admin.settings.fields.authorize_between_accounts'), 'value' => setting('fund_authorize_transfer_between_accounts', true)])
                </div>

                <div>
                </div>
                <div>
                    @include('admin/shared/input', ['name' => 'fund_transfer_min_amount', 'label' => __('fund::messages.admin.settings.fields.min_amount'), 'value' => setting('fund_transfer_min_amount', '5'), ['type' => 'number']])
                </div>
                    <div>
                    @include('admin/shared/input', ['name' => 'fund_transfer_max_amount', 'label' => __('fund::messages.admin.settings.fields.max_amount'), 'value' => setting('fund_transfer_max_amount', '1000'), ['type' => 'number']])
                </div>

                <div>
                    @include('admin/shared/input', ['name' => 'fund_transfer_minutes_delay', 'label' => __('fund::messages.admin.settings.fields.minutes_delay'), 'help' => __('fund::messages.admin.settings.fields.minutes_delay_description'), 'value' => setting('fund_transfer_minutes_delay', '5'), ['type' => 'number']])
                </div>
                <div>
                    @include('admin/shared/input', ['name' => 'fund_transfer_min_invoice', 'label' => __('fund::messages.admin.settings.fields.min_invoice'), 'help' => __('fund::messages.admin.settings.fields.min_invoice_description'), 'value' => setting('fund_transfer_min_invoice', '5'), ['type' => 'number']])
                </div>
            </div>
            @method('PUT')
            <button type="submit" class="btn btn-primary mt-3 ">{{ __('global.save') }}</button>
        </form>
@endsection
