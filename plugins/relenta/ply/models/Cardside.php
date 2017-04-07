<?php namespace Relenta\Ply\Models;

use Model;

/**
 * Category Model
 */
class Cardside extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'relenta_ply_card_side';

    /**
     * @var string Primary key field name
     */
    public $primaryKey = 'card_side_id';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var bool Indicates if the model should be timestamped.
     */
    public $timestamps = false;

}
