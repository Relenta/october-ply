<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Relenta\Ply\Models\Course as Course;

class Courses extends ComponentBase
{
    /**
     * A collection of courses to display
     * @var Collection
     */
    public $courses;
    
    public function componentDetails()
    {
        return [
            'name' => 'GetPly Courses',
            'description' => 'Displays a collection of courses.'
        ];
    }

    public function onRun()
    {
        // TODO get courses
    }
}