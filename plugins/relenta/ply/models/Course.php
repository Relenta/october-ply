<?php namespace Relenta\Ply\Models;

use Model;

/**
 * Course Model
 */
class Course extends Model
{

    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'title'];
    
    /**
     * @var string The database table used by the model.
     */
    protected $table = 'relenta_ply_course';

    /**
     * @var bool Indicates if the model should be timestamped.
     */
    public $timestamps = true;

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['author_id'];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'units' => ['Relenta\Ply\Models\Unit'],
        'cards' => ['Relenta\Ply\Models\Card'],
    ];

    public $belongsTo = [
        'category' => ['Relenta\Ply\Models\Category'],
    ];

    /**
     * @var array Relations
     */
    //public $hasOne = [
    //    'author' => ['Relenta\Ply\Models\User']
    //];

}
