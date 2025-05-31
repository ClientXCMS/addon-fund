<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('admin/settings/sidebar')
@section('title', __('fund::messages.admin.transfers.title'))
@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="card">
                        <div class="card-heading">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                    {{ __('fund::messages.admin.transfers.title') }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('fund::messages.admin.transfers.subtitle') }}
                                </p>
                            </div>
                        </div>

                    <div class="border rounded-lg overflow-hidden dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>

                            <tr>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      #
                    </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('global.customer') }}
                    </span>
                                    </div>
                                </th>
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
                                    <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">

                                        {{ __('fund::messages.admin.transfers.transferred_at') }}
                                                            </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">

                                        {{ __('global.created') }}
                    </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">

                                        {{ __('global.actions') }}
                    </span>
                                    </div>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @if (count($items) == 0)
                                <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center">
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
                      <span class="text-sm text-gray-600 dark:text-gray-400">{{ $item->id }}</span>
                    </span>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap">
                    <span class="block px-6 py-2">
                      <span class="text-sm text-gray-600 dark:text-gray-400">
                          <a href="{{ route('admin.customers.show', ['customer' => $item->customer]) }}">
                              {{ $item->customer->excerptFullName() }}
                          </a>
                      </span>
                    </span>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap">
                    <span class="block px-6 py-2">
                      <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    <a href="{{ route('admin.customers.show', ['customer' => $item->customer]) }}">

                          {{ $item->recipient->fullName }}
                                                    </a>
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
                    <span class="block px-6 py-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $item->transferred_at ? $item->transferred_at->format('d/m/y H:i:s') : '--' }}
                        </span>
                    </span>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap">
                    <span class="block px-6 py-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $item->created_at->format('d/m/y H:i:s') }}
                        </span>
                    </span>
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
                    </div>

                    <div class="py-1 px-4 mx-auto">
                        {{ $items->links('admin.shared.layouts.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
