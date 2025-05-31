<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property array<array-key, mixed>|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereUserId($value)
 * @mixin \Eloquent
 */
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
