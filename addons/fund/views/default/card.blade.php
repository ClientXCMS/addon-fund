<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@php
    $items = \App\Addons\Fund\Models\FundsTransfer::where('customer_id', auth('web')->user()->id)->orderBy('id', 'desc')->paginate(5);
@endphp
    <script>
        window.currency = "{{ currency() }}";
    </script>
    <script src="{{ Vite::asset('resources/themes/default/js/fund.js') }}"></script>

<div class="card">
    @if (empty($gatewaysOptions))
        <div class="alert text-yellow-800 bg-yellow-100 mt-2" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            {{ __('fund::messages.card.error') }}
        </div>
    @else
    <form method="POST" action="{{ route('fund.add_fund') }}">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>

                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('fund::messages.card.title') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('fund::messages.card.description') }}
                </p>
                    @csrf
                    @include('shared/input', ['amount' => 'amount', 'label' => __('fund::messages.card.amount'), 'name' => 'amount', 'value' => setting('fund_credit_min_amount', 5), 'type' => 'number', 'attributes' => ['step' => '1', 'min' => setting('fund_credit_min_amount'), 'max' => setting('fund_credit_max_amount')]])
                @include('shared/select', ['name' => 'gateway', 'label' => __('fund::messages.card.gateway'), 'options' => $gatewaysOptions, 'value' => 'stripe'])
            </div>
            <div class="dark:text-gray-400 text-gray-800">
                <h2 class="text-xl font-semibold text-right text-gray-800 dark:text-gray-200 mb-4">{{ __('store.config.summary') }}</h2>


                <div class="flex justify-between mb-2">
                    <span>{{ __('fund::messages.card.currentbalance') }}</span>
                    <span>{{ formatted_price(auth('web')->user()->balance) }}</span>
                </div>

                <div class="flex justify-between mb-2">
                    <span>{{ __('fund::messages.card.amount') }}</span>
                    <span id="amount" data-currency="{{ currency() }}" data-balance="{{ auth('web')->user()->balance }}">0</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>{{ __('fund::messages.card.next_balance') }}</span>
                    <span id="balance">{{ formatted_price(auth('web')->user()->balance) }}</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between mb-2">
                    <span class="font-semibold">{{ __('store.total_topay') }}</span>
                    <span class="font-semibold" id="total">0</span>
                </div>
                <button class="bg-indigo-600 text-white py-2 px-4 rounded-lg mt-4 w-full" type="submit">{{ __('global.pay') }}</button>

            </div>
        </div>
    </form>
        @endif

</div>
    @if (setting('fund_authorize_transfer_between_accounts', true))
    <div class="card">
        @if (\App\Addons\Fund\DTO\AddFundDTO::getMinInvoiceValue() < setting('fund_transfer_min_invoice', '5'))

            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('fund::messages.transfer.title') }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('fund::messages.transfer.description') }}
            </p>
            <div class="alert text-yellow-800 bg-yellow-100 mt-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                {{ __('fund::messages.transfer.min_invoice', ['amount' => formatted_price(setting('fund_transfer_min_invoice', '5'))]) }}
            </div>
        @else

        <form method="POST" action="{{ route('fund.create_transfer') }}">
            <div class="grid grid-cols-2 gap-4">
                <div>

                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('fund::messages.transfer.title') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('fund::messages.transfer.description') }}
                    </p>
                    @csrf
                    @include('shared/input', ['amount' => 'amount', 'label' => __('fund::messages.card.amount'), 'name' => 'amount', 'value' => setting('fund_transfer_min_amount'), 'type' => 'number', 'attr' => ['step' => '1', 'min' => setting('fund_transfer_min_amount'), 'max' => setting('fund_transfer_max_amount')]])
                    @include('shared/input', ['name' => 'recipient', 'label' => __('fund::messages.transfer.recipient'), 'value' => old('recipient'), 'type' => 'email'])
                </div>
                <div class="dark:text-gray-400 text-gray-800">
                    <h2 class="text-xl font-semibold text-right text-gray-800 dark:text-gray-200 mb-4">{{ __('store.config.summary') }}</h2>
                    <div class="flex justify-between mb-2">
                        <span>{{ __('fund::messages.admin.settings.fields.min_amount') }}</span>
                        <span>{{ formatted_price(setting('fund_transfer_min_amount', '5')) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>{{ __('fund::messages.admin.settings.fields.max_amount') }}</span>
                        <span>{{ formatted_price(setting('fund_transfer_max_amount', '1000')) }}</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>{{ __('fund::messages.card.currentbalance') }}</span>
                        <span>{{ formatted_price(auth('web')->user()->balance) }}</span>
                    </div>
                    <button class="bg-indigo-600 text-white py-2 px-4 rounded-lg mt-4 w-full" type="submit">{{ __('fund::messages.transfer.btn') }}</button>

                </div>
            </div>
        </form>
            @endif
    </div>
            <div class="card">

                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('fund::messages.transfer_table.title') }}
                </h2>

                <div class="border rounded-lg overflow-hidden dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>

                        <tr>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('fund::messages.recipient') }}
                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-start">
                                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">

                                        {{ __('global.amount') }}
                                                            </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('global.status') }}
                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 text-start">
                                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">

                                        {{ __('global.actions') }}
                                                            </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @if (count($items) == 0)
                            <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-auto flex-col justify-center items-center p-2 md:p-3">
                                        <p class="text-sm text-gray-800 dark:text-gray-400">
                                            {{ __('global.no_results') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach($items as $item)

                            <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                <td class="h-px w-px whitespace-nowrap">
                    <span class="block px-6 py-2">
                      <span class="text-sm text-gray-600 dark:text-gray-400">
                          {{ $item->recipient->email }}
                      </span>
                    </span>
                                </td>

                                <td class="h-px w-px whitespace-nowrap">
                    <span class="block px-6 py-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ formatted_price($item->amount) }}
                        </span>
                    </span>
                                </td>

                                <td class="h-px w-px whitespace-nowrap px-6">
                                    <x-badge-state state="{{ $item->status }}"></x-badge-state>
                                </td>
                                <td class="h-px w-px whitespace-nowrap">
                                    @if ($item->status == 'pending')
                                    <form method="POST" action="{{ route('fund.cancel_transfer', ['transfer' => $item]) }}" class="inline confirmation-popup">
                                        @method('DELETE')
                                        @csrf
                                        <button>
                                          <span class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-red text-red-700 shadow-sm align-middle hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-red-900 dark:hover:bg-red-800 dark:border-red-700 dark:text-white dark:hover:text-white dark:focus:ring-offset-gray-800">
                                              <i class="bi bi-x"></i>

                                            {{ __('global.cancel') }}
                                          </span>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="py-1 px-4 mx-auto">
                    {{ $items->links('shared.layouts.pagination') }}
                </div>
            </div>
        @endif
