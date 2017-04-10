<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;

class Units extends ComponentBase
{
    /**
     * A collection of units to display
     * @var Collection
     */
    public $units;

    public function componentDetails()
    {
        return [
            'name' => 'GetPly Units',
            'description' => 'Displays a collection of units.'
        ];
    }

    public function onRun()
    {
        // todo get units
    }
}