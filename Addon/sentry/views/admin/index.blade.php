<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('admin.settings.sidebar')
@section('title', __('sentry::admin.title'))
@section('setting')
    <div class="card">
        <h4 class="font-semibold uppercase text-gray-600 dark:text-gray-400">
            {{ __('sentry::admin.title') }}
        </h4>
        <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
            {{ __('sentry::admin.description') }}
        </p>
        <form action="{{ route('admin.sentry.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3">
                    @include('admin/shared/password', ['name' => 'dsn', 'label' => __('sentry::admin.fields.dsn'), 'value' => env('SENTRY_LARAVEL_DSN')])
                </div>
                <div>
                    @include('admin/shared/input', ['name' => 'environment', 'label' => __('sentry::admin.fields.environment'), 'value' => env('SENTRY_ENVIRONMENT', env('APP_ENV'))])
                </div>
                <div>
                    @include('admin/shared/input', ['name' => 'traces_sample_rate', 'label' => __('sentry::admin.fields.traces_sample_rate'), 'value' => env('SENTRY_TRACES_SAMPLE_RATE', 1), 'type' => 'number'])
                </div>
                <div>
                    @include('admin/shared/input', ['name' => 'profiles_sample_rate', 'label' => __('sentry::admin.fields.profiles_sample_rate'), 'value' => env('SENTRY_PROFILES_SAMPLE_RATE', 1), 'type' => 'number'])
                </div>
            </div>
            @method('PUT')
            <button type="submit" class="btn btn-primary mt-3 ">{{ __('global.save') }}</button>
        </form>
@endsection
