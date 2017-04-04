<?php namespace Relenta\Ply\Models;

use Model;
use ApplicationException;

/**
 * Course Model
 */
class Course extends Model
{

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'relenta_ply_course';
    
    /**
     * @var string Primary key field name
     */
    public $primaryKey = 'course_id';
    
    /**
     * @var bool Indicates if the model should be timestamped.
     */ 
    public $timestamps = false;

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    //public $hasMany = [
    //    'units' => ['Relenta\Ply\Models\Unit'],
    //    'cards' => ['Relenta\Ply\Models\Card']
    //];

    /**
     * @var array Relations
     */
    //public $hasOne = [
    //    'author' => ['Relenta\Ply\Models\User']
    //];

}
