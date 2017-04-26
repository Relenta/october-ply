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

    /**
     * Current unit
     * @var Unit
     */
    public $unit;

    /**
     * Current course
     * @var Course
     */
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
            $this->unit = $this->page['unit'] = $this->getUnit();

            if (!$this->unit)
                $this->callNotFoundPage();

            $this->cards = $this->page['cards'] = $this->getCardsByUnit();
        }
        if ($this->courseSlug() != '')
        {
            $this->course = $this->page['course'] = $this->getCourse();

            if (!$this->course)
                $this->callNotFoundPage();
        }
        #$this->cards = $this->page['cards'] = $this->getCardsByCourse();
        #else {
        #    throw new SystemException('Relenta/Ply/Components/Cards: Wrong params definition.');
        #}
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
    public function unitSlug()
    {
        $routeParameter = $this->property('unitSlug');

        return $this->param($routeParameter);
    }

    /**
     * Returns the collection of cards by unit
     * @return Collection
     */
    public function getCardsByUnit()
    {
        return Card::where('unit_id', $this->unit->id)
            ->get();
    }

    /**
     * Returns the collection of cards by course
     * @return Collection
     */
    public function getCardsByCourse()
    {
        return Card::where('course_id', $this->course->id)
            ->get();
    }

    /**
     * Returns unit by slug
     * @return Unit
     */
    public function getUnit()
    {
        return Unit::where('slug', $this->unitSlug())
            ->first();
    }

    /**
     * Returns course by slug
     * @return Course
     */
    public function getCourse() {
        return Course::where('slug', $this->courseSlug())
            ->first();
    }

    /**
     * Returns not-found page with 404 status code
     * @return Response
     */
    public function callNotFoundPage() {
        $this->setStatusCode(404);
        return $this->controller->run('404');
    }

}