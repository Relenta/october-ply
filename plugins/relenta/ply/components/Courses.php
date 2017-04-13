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
            'categoryIdParam' => [
                'title'             => 'Category Id Parameter',
                'description'       => 'Name of variable, which contains category id',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Category Id parameter is required'
            ]
        ];
    }

    public function onRun()
    {
        $this->courses = $this->getCourses();
        //$this->category = $this->courses[0]->category()->get();
    }

    /**
     * Returns the category id from the URL
     * @return string
     */
    public function categoryId()
    {
        $routeParameter = $this->property('categoryIdParam');

        return $this->param($routeParameter);
    }

    public function getCourses()
    {
        return Course::where('category_id', $this->categoryId())
            ->get();
    }
}