<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Category;

class Courses extends ComponentBase
{
    /**
     * A collection of courses to display
     * @var Collection
     */
    public $courses;
    public $category;
    
    public function componentDetails()
    {
        return [
            'name' => 'GetPly Courses',
            'description' => 'Displays a collection of courses.'
        ];
    }

    public function defineProperties()
    {
        return [
            'categorySlug' => [
                'title'             => 'Category Slug Parameter',
                'description'       => 'Name of variable, which contains category slug',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Category Slug parameter is required'
            ]
        ];
    }

    public function onRun()
    {
        $this->category = $this->getCategory();
        $this->courses = $this->getCourses();
    }

    /**
     * Returns the category slug from the URL
     * @return string
     */
    public function categorySlug()
    {
        $routeParameter = $this->property('categorySlug');

        return $this->param($routeParameter);
    }

    public function getCourses()
    {
        return Course::where('category_id', $this->category->id)->get();
    }

    public function getCategory()
    {
        return Category::where('slug', $this->categorySlug())->first();
    }
}