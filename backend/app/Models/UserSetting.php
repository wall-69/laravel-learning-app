<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        "user_id", "setting"
    ];

    protected $casts = [
        "settings" => "array"
    ];

    public function set(string $key, mixed $value)
    {
        // Get the current settings or create empty array
        $settings = $this->settings ?? [];

        // Overwrite or set the setting
        $settings[$key] = $value;

        // Save
        $this->settings = $settings;
        $this->save();
    }
}
