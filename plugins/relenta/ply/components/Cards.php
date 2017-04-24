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
            'name'          => 'relenta.ply::lang.components.cards.name',
            'description'   => 'relenta.ply::lang.components.cards.description'
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
            'unitSlug' => [
                'title'             => 'relenta.ply::lang.properties.unit_slug_title',
                'description'       => 'relenta.ply::lang.properties.unit_slug_description',
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
            throw new SystemException('Relenta/Ply/Components/Cards: Wrong params definition.');
        }
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