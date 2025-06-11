<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string|null $group
 * @property string|null $key
 * @property string|null $value
 * @property string|null $type
 * @property string $created_at
 * @property string $updated_at
 */
class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_settings';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'group' => 'string',
        'key' => 'string',
        'value' => 'string',
        'type' => 'string',
    ];
}
