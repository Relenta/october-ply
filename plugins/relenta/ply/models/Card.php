<?php namespace Relenta\Ply\Models;

use Model;

/**
 * Category Model
 */
class Card extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'relenta_ply_card';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var bool Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * @var array Relations
     */
    public $hasMany = [
        'sides' => ['Relenta\Ply\Models\CardSide'],
    ];

}
