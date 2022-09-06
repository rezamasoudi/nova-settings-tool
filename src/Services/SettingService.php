<?php

namespace Masoudi\Nova\Tool\Services;

use Masoudi\Nova\Tool\Models\Setting;
use Masoudi\Nova\Tool\SettingsTool;

class SettingService
{
    /**
     * Get all settings\
     * 
     * @param string $group_label
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getAll($group_label = null)
    {
        // Define group label
        if (!$group_label) {
            $group_label = SettingsTool::$groupLabel;
        }

        $values = Setting::query();
        if (!is_null($group_label)) {
            $values = $values->where('group_label', $group_label);
        }

        return $values->get();
    }

    /**
     * Get setting by key name
     * 
     * @param string key
     * @param \Illuminate\Database\Eloquent\Collection|null $setings
     * @return string|null
     */
    public function getSettingByKey($key, $settings = null)
    {
        if (!$settings) {
            $settings = $this->getAll();
        }

        foreach ($settings as $setting) {
            if ($setting->key == $key) {
                return $setting->value;
            }
        }

        return null;
    }

    /**
     * Update or create setting
     * 
     * @param string $key
     * @param string $value
     * @param string|null $group_label
     */
    public function updateOrCreate($key, $value, $group_label = null)
    {
        $conditions = ['key' => $key];
        if ($group_label) {
            $conditions['group_label'] = $group_label;
        }

        Setting::query()->updateOrCreate($conditions, compact('key', 'value', 'group_label'));
    }
}
