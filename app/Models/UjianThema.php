<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ujian_id
 * @property string $theme
 * @property string $logo_path
 * @property string $background_image_path
 * @property string $header_image_path
 * @property string $institution_name
 * @property string $welcome_message
 * @property string $background_color
 * @property string $header_color
 * @property boolean $use_custom_color
 * @property string $primary_color
 * @property string $secondary_color
 * @property string $tertiary_color
 * @property string $created_at
 * @property string $updated_at
 */
class UjianThema extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ujian_id',
        'theme',
        'logo_path',
        'background_image_path',
        'header_image_path',
        'institution_name',
        'welcome_message',
        'background_color',
        'header_color',
        'use_custom_color',
        'primary_color',
        'secondary_color',
        'tertiary_color',
        'font_color',
        'button_color',
        'button_font_color',
    ];

    /**
     * @var string
     */
    protected $table = 'ujian_themas';
    /**
     * @var string
     */

    //  relationship with Ujian model
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }
}
