<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Relenta\Ply\Models\Category;

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
        $this->categories = $this->getCategories();
    }

    public function getCategories()
    {
        return Category::All()->toNested();
    }
}