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
            'courseIdParam' => [
                'title'             => 'Course Id Parameter',
                'description'       => 'Name of variable, which contains course id',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Course id parameter is required'
            ],
            'unitIdParam' => [
                'title'             => 'Unit Id Parameter',
                'description'       => 'Name of variable, which contains unit id',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Unit id parameter is required'
            ],
        ];
    }

    public function onRun()
    {
        $this->cards = $this->getCards();
        $this->unit = $this->getUnit();
    }

    public function courseId()
    {
        $routeParameter = $this->property('courseIdParam');

        return $this->param($routeParameter);
    }

    public function unitId()
    {
        $routeParameter = $this->property('unitIdParam');

        return $this->param($routeParameter);
    }

    public function getCards()
    {
        return Card::where('unit_id', $this->unitId())
            ->get();
    }

    public function getUnit()
    {
        return Unit::where('id', $this->unitId())
            ->first();
    }

}