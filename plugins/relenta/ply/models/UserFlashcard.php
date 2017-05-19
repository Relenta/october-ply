<?php namespace Relenta\Ply\Models;

use Model;

/**
 * User card SM2 statistics Model
 */
class UserFlashCard extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'relenta_ply_user_flashcard';

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
    public $belongTo = [
        'user'   => ['RainLab\User\Models\User']
    ];

    public $hasOne = [
        'card'   => ['Relenta\Ply\Models\Card']
    ];

}
