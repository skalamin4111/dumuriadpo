<?php

namespace App\Services\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    public function get(string $key, mixed $default = null, string $group = 'general'): mixed
    {
        $companyId = auth()->user()?->company_id;

        return Cache::remember("settings:{$companyId}:{$group}:{$key}", 3600, function () use ($companyId, $group, $key, $default) {
            return Setting::query()
                ->where('company_id', $companyId)
                ->where('group', $group)
                ->where('key', $key)
                ->value('value') ?? $default;
        });
    }

    public function set(string $key, mixed $value, string $group = 'general', string $type = 'string'): Setting
    {
        $companyId = auth()->user()?->company_id;

        $setting = Setting::updateOrCreate(
            ['company_id' => $companyId, 'group' => $group, 'key' => $key],
            ['value' => $value, 'type' => $type]
        );

        Cache::forget("settings:{$companyId}:{$group}:{$key}");

        return $setting;
    }
}
