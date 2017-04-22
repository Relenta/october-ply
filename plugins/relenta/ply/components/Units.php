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
            'courseSlug' => [
                'title'             => 'Course Slug Parameter',
                'description'       => 'Name of variable, which contains course slug',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Course slug parameter is required'
            ]
        ];
    }

    public function onRun()
    {
        $this->course = $this->getCourse();

        if (!$this->course) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }

        $this->units = $this->getUnits();
    }

    /**
     * Returns the course slug from the URL
     * @return string
     */
    public function courseSlug()
    {
        $routeParameter = $this->property('courseSlug');

        return $this->param($routeParameter);
    }

    public function getUnits()
    {
        return Unit::where('course_id', $this->course->id)
            ->get()
            ->toNested();
    }

    public function getCourse()
    {
        return Course::where('slug', $this->courseSlug())
            ->first();
    }
}