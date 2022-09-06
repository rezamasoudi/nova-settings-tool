<?php

namespace Masoudi\Nova\Tool;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class SettingsTool extends Tool
{
    public static $groupLabel = null;

    public function boot()
    {
        Nova::script('nova-settings-tool', __DIR__ . '/../dist/js/tool.js');
    }

    public function menu(Request $request)
    {
        return MenuSection::make(__(config('nova-settings-tool.sidebar-label', 'Settings')))
            ->path('/settings')
            ->icon('cog');
    }

    public static function setGroupLabel($label = null)
    {
        static::$groupLabel = $label;
    }
}
