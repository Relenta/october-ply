<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\CardSide;
use Relenta\Ply\Models\Unit;

class Cards extends ComponentBase
{
    /**
     * A collection of cards to display
     * @var Collection
     */
    public $cards;
    public $unit;

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
                'description'       => 'Name of variable, which contains unit slug',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Unit slug parameter is required'
            ],
        ];
    }

    public function onRun()
    {
        $this->unit = $this->getUnit();

        if (!$this->unit) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }

        $this->cards = $this->getCards();
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

    public function getCards()
    {
        return Card::where('unit_id', $this->unit->id)
            ->get();
    }

    public function getUnit()
    {
        return Unit::where('slug', $this->unitSlug())
            ->first();
    }

}