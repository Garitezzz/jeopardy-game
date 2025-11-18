<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Settings Model
 * 
 * Stores application-wide settings as key-value pairs.
 * Provides static helper methods for easy getting and setting of configuration values.
 * 
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Settings extends Model
{
    protected $fillable = ['key', 'value'];
    
    /**
     * Get a setting value by key
     * Returns the default value if the key doesn't exist
     * 
     * @param string $key The setting key to retrieve
     * @param mixed $default The default value to return if key not found
     * @return mixed The setting value or default
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    /**
     * Set a setting value by key
     * Creates a new setting if it doesn't exist, updates if it does
     * 
     * @param string $key The setting key to set
     * @param mixed $value The value to store
     * @return \App\Models\Settings The created or updated setting model
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
