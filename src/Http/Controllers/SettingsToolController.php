<?php

namespace Masoudi\Nova\Tool\Http\Controllers;

use Illuminate\Http\Request;
use Masoudi\Nova\Tool\Services\SettingService;
use Masoudi\Nova\Tool\SettingsTool;
use Masoudi\Nova\Tool\Support\Translate;

class SettingsToolController
{
    use Translate;

    private SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function read()
    {
        $values = $this->settingService->getAll();
        $settings = collect(config('nova-settings-tool.settings'));

        $panels = $settings->where('panel', '!=', null)->pluck('panel')->unique()
            ->flatMap(function ($panel) use ($settings) {
                return [trans($panel) => $settings->where('panel', $panel)->pluck('key')->all()];
            })
            ->when($settings->where('panel', null)->isNotEmpty(), function ($collection) use ($settings) {
                return $collection->merge([trans('Other') => $settings->where('panel', null)->pluck('key')->all()]);
            })
            ->all();

        $settings = $settings->map(function ($setting) use ($values) {

            $item = array_merge([
                'type' => 'text',
                'label' => ucfirst($setting['key']),
                'value' => $this->settingService->getSettingByKey($setting['key'], $values) ?? null,
            ], $setting);

            $item = $this->applyTranslation($item);

            return $item;
        })
            ->keyBy('key')
            ->all();

        return response()->json([
            'title' => trans(config('nova-settings-tool.title', 'Settings')),
            'settings' => $settings,
            'panels' => $panels,
        ]);
    }

    public function write(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $this->settingService->updateOrCreate($key, $value, SettingsTool::$groupLabel);
        }

        return response()->json();
    }

    private function applyTranslation($item)
    {
        $this->transArrayValue('label', $item);
        $this->transArrayValue('help', $item);
        $this->transArrayValue('placeholder', $item);

        if (array_key_exists('options', $item) && is_array($item['options'])) {
            foreach ($item['options'] as $key => $_) {
                $this->transArrayValue($key,  $item['options']);
            }
        }
        return $item;
    }
}
