<?php

namespace Masoudi\Nova\Tool\Events;

class SettingsChanged
{
    public $settings;
    public $oldSettings;

    public function __construct(array $settings, array $oldSettings)
    {
        $this->settings = $settings;
        $this->oldSettings = $oldSettings;
    }
}
