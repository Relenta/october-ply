<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;

class Cards extends ComponentBase
{
    /**
     * A collection of cards to display
     * @var Collection
     */
    public $cards;

    public function componentDetails()
    {
        return [
            'name' => 'GetPly Cards',
            'description' => 'Displays a collection of cards.'
        ];
    }

    public function onRun()
    {
        // TODO get cards
    }

}