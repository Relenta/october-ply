<?php namespace Relenta\Ply\Models;

use Model;

/**
 * Unit Model
 */
class Unit extends Model
{

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'relenta_ply_unit';

    /**
     * @var bool Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'course' => ['Relenta\Ply\Models\Course'],
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'cards' => ['Relenta\Ply\Models\Card'],
    ];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = ['title'];

}
