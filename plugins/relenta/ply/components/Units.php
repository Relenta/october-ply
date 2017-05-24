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

    /**
     * Current course
     * @var Course
     */
    public $course;

    /**
     * Current parent unit
     * @var Unit
     */
    public $parentUnit;

    public function componentDetails()
    {
        return [
            'name'          => 'relenta.ply::lang.components.units.name',
            'description'   => 'relenta.ply::lang.components.units.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'courseSlug' => [
                'title'             => 'relenta.ply::lang.properties.course_slug_title',
                'description'       => 'relenta.ply::lang.properties.course_slug_description',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'relenta.ply::lang.properties.course_slug_validation_message'
            ],
            'parentUnitSlug' => [
                'title'             => 'relenta.ply::lang.properties.unit_slug_title',
                'description'       => 'relenta.ply::lang.properties.unit_slug_description',
                'type'              => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->course = $this->page['course'] = $this->getCourse();

        if (!$this->course)
        {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }

        $this->parentUnit   = $this->page['parentUnit'] = $this->getParentUnit();
        $this->units        = $this->page['units']      = $this->getUnits();
        
        if (!$this->units)
        {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }
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

    /**
     * Returns the unit slug from the URL
     * @return string
     */
    public function parentUnitSlug()
    {
        $routeParameter = $this->property('parentUnitSlug');

        return $this->param($routeParameter);
    }

    /**
     * Returns the nested collection of units by course
     * @return Collection
     */
    public function getUnits()
    {
        $query = Unit::where('course_id', $this->course->id);
        if ($this->parentUnit) {
            $query->where('parent_id', $this->parentUnit->id);
        }
        else {
            $query->whereNull('parent_id');
        }
        return $query->get();
    }

    /**
     * Returns course by slug
     * @return Course
     */
    public function getCourse()
    {
        return Course::where('slug', $this->courseSlug())
            ->first();
    }

    /**
     * Returns unit by slug
     * @return Unit
     */
    public function getParentUnit()
    {
        return Unit::where('slug', $this->parentUnitSlug())
            ->first();
    }
}