<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Unit;

class Units extends ComponentBase
{
    /**
     * A collection of units to display
     * @var Collection
     */
    public $units;
    public $course;

    public function componentDetails()
    {
        return [
            'name' => 'GetPly Units',
            'description' => 'Displays a collection of units.'
        ];
    }

    public function defineProperties()
    {
        return [
            'courseIdParam' => [
                'title'             => 'Course Id Parameter',
                'description'       => 'Name of variable, which contains course id',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Course id parameter is required'
            ]
        ];
    }

    public function onRun()
    {
        $this->units = $this->getUnits();
        $this->course = $this->getCourse();
    }

    /**
     * Returns the course id from the URL
     * @return string
     */
    public function courseId()
    {
        $routeParameter = $this->property('courseIdParam');

        return $this->param($routeParameter);
    }

    public function getUnits()
    {
        return Unit::where('course_id', $this->courseId())
            ->get()->toNested();
    }

    public function getCourse()
    {
        return Course::where('id', $this->courseId())
            ->first();
    }
}