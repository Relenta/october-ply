<?php namespace Relenta\Ply\Models;

use Model;
use ApplicationException;

/**
 * Category Model
 */
class Category extends Model
{
    
    use \October\Rain\Database\Traits\SimpleTree;
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'relenta_ply_category';

    /**
     * @var string Primary key field name
     */
    public $primaryKey = 'category_id';
    
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
    public $hasMany = [
        'courses' => ['Relenta\Ply\Models\Course']
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'parent' => ['Relenta\Ply\Models\Category']
    ];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = ['category_title'];

}
