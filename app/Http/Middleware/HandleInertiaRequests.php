<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'flash' => [
                'info' => fn () => $request->session()->get('info'),
                'success' => fn () => $request->session()->get('success'),
                'failed' => function () use ($request) {
                    return $this->gettingErrorMessage($request);
                },
                'id' => now()->timestamp,
            ],
            'auth' => [
                'user' => $request->user(),
                'permissions' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : [],
                'roles' => $request->user() ? $request->user()->getRoleNames() : [],
            ],
            'app' => $this->getGeneralSetting(),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }

    protected function gettingErrorMessage(Request $request)
    {
        if (!$request->session()->get('errors') && !$request->session()->get('failed')) return null;
        if ($request->session()->get('failed')) return $request->session()->get('failed');
        // Retrieve error bags from session
        $errors = $request->session()->get('errors')->getBags();
        $errorBagName = $request->header('x-inertia-error-bag', 'default');

        // Define a function to get the first error message as a string
        $getFirstErrorMessage = function ($errorBag) {
            return collect($errorBag->messages())->flatten()->first();
        };

        // Check if the specified error bag exists and has messages
        if (isset($errors[$errorBagName]) && !empty($errors[$errorBagName]->messages())) {
            return (string) $getFirstErrorMessage($errors[$errorBagName]);
        }

        // Fallback to the first message from any bag if specified bag is empty or doesn't exist
        return (string) $getFirstErrorMessage(collect($errors)->first());
    }

  
    protected function getGeneralSetting()
    {
        $generalSetting = Cache::get('general-setting');
        if (!$generalSetting) {
            $generalSetting = [
                'brand_name' => config('app.name'),
                'brand_logo' => config('app.brand_logo'),
            ];
            Cache::put('general-setting', $generalSetting);
        }
        return $generalSetting;
    }
}
