<?php

namespace Masoudi\Nova\Tool;

use Masoudi\Nova\Tool\Http\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class SettingsToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/nova-settings-tool.php' => config_path('nova-settings-tool.php'),
            __DIR__ . '/../database/2022_09_06_092351_create_settings_table.php' => database_path('migrations/2022_09_06_092351_create_settings_table.php'),
        ], 'nova-settings-tool');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function () {
            Nova::translations([
                'Settings saved!' => trans('Settings saved!'),
                'Failed to save settings!' => trans('Failed to save settings!'),
                'Save Settings' => trans('Save Settings'),
            ]);
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authorize::class], 'settings')
            ->group(__DIR__ . '/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-settings-tool')
            ->group(__DIR__ . '/../routes/api.php');
    }
}
