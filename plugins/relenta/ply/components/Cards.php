<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use October\Rain\Exception\SystemException;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\CardSide;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Unit;

class Cards extends ComponentBase
{
    /**
     * A collection of cards to display
     * @var Collection
     */
    public $cards;
    public $unit;
    public $course;

    public function componentDetails()
    {
        return [
            'name' => 'GetPly Cards',
            'description' => 'Displays a collection of cards.'
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
            ],
            'unitSlug' => [
                'title'             => 'Unit Slug Parameter',
                'description'       => 'If Unit slug is not declared, cards will be searched by course.',
                'type'              => 'string',
                'required'          => false
            ],
        ];
    }

    public function onRun()
    {
        if ($this->unitSlug() != '')
        {
            $this->unit = $this->getUnit();

            if (!$this->unit)
                $this->callNotFoundPage();

            $this->cards = $this->getCardsByUnit();
        }
        else if ($this->courseSlug() != '')
        {
            $this->course = $this->getCourse();

            if (!$this->course)
                $this->callNotFoundPage();

            $this->cards = $this->getCardsByCourse();
        }
        else {
            throw new SystemException('Relenta/Ply/Components/Cards: Wrong slug definition.');
        }



        /*if (!$this->unit)
        {


            if (!$this->course)
            {
                $this->setStatusCode(404);
                return $this->controller->run('404');
            }

            $this->cards = $this->getCardsByCourse();
        }
        else
        {
            $this->cards = $this->getCardsByUnit();
        }*/


    }

    public function courseSlug()
    {
        $routeParameter = $this->property('courseSlug');
        return $this->param($routeParameter);
    }

    public function unitSlug()
    {
        $routeParameter = $this->property('unitSlug');

        return $this->param($routeParameter);
    }

    public function getCardsByUnit()
    {
        return Card::where('unit_id', $this->unit->id)
            ->get();
    }

    public function getCardsByCourse()
    {
        return Card::where('course_id', $this->course->id)
            ->get();
    }

    public function getUnit()
    {
        return Unit::where('slug', $this->unitSlug())
            ->first();
    }

    public function getCourse() {
        return Course::where('slug', $this->courseSlug())
            ->first();
    }

    public function callNotFoundPage() {
        $this->setStatusCode(404);
        return $this->controller->run('404');
    }

}