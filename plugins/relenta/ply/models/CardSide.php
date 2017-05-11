<?php namespace Relenta\Ply\Models;

use Model;

/**
 * Category Model
 */
class CardSide extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'relenta_ply_card_side';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    protected $with = ['media'];

    /**
     * @var bool Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    public function getPathAttribute() {
        return $this->media()->getPath();
    }

    public $attachOne = [
        'media' => ['System\Models\File', 'public' => false]
    ];

}
