<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Relenta\Ply\Models\Category as Category;

class Categories extends ComponentBase
{
    /**
     * A collection of categories to display
     * @var Collection
     */
    public $categories;

    public function componentDetails()
    {
        return [
            'name' => 'GetPly Categories',
            'description' => 'Displays a collection of categories (themes).'
        ];
    }

    public function onRun()
    {
        $this->categories = ["Russian", "English", "French"];
        // TODO get categories
    }
}