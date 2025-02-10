<?php

namespace App\Addons\Sentry\Controllers;

use App\Helpers\EnvEditor;
use Illuminate\Http\Request;

class SentryController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view('sentry_admin::index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dsn' => 'required|url|string',
            'traces_sample_rate' => 'required|numeric',
            'profiles_sample_rate' => 'required|numeric',
            'environment' => 'nullable|string',
        ]);
        EnvEditor::updateEnv([
            'SENTRY_LARAVEL_DSN' => $validated['dsn'],
            'SENTRY_TRACES_SAMPLE_RATE' => $validated['traces_sample_rate'],
            'SENTRY_PROFILES_SAMPLE_RATE' => $validated['profiles_sample_rate'],
            'SENTRY_ENVIRONMENT' => $validated['environment'],
        ]);
        return redirect()->back()->with('success', __('sentry::admin.saved'));
    }
}
