<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;

class CourseCreate extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'          => 'relenta.ply::lang.components.course_create.name',
            'description'   => 'relenta.ply::lang.components.course_create.description'
        ];
    }

    public function onRun()
    {
    }

    public function onSubmit() {

    }
}