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

    /**
     * Current category
     * @var Category
     */
    public $category;
    
    public function componentDetails()
    {
        return [
            'name'          => 'relenta.ply::lang.components.courses.name',
            'description'   => 'relenta.ply::lang.components.courses.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'categorySlug' => [
                'title'             => 'relenta.ply::lang.properties.category_slug_title',
                'description'       => 'relenta.ply::lang.properties.category_slug_description',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'relenta.ply::lang.properties.category_slug_validation_message'
            ]
        ];
    }

    public function onRun()
    {
        $this->category = $this->page['category'] = $this->getCategory();

        if (!$this->category) 
        {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }

        $this->courses = $this->page['courses'] = $this->getCourses();
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

    /**
     * Returns the collection of courses by category
     * @return Collection
     */
    public function getCourses()
    {
        return Course::where('category_id', $this->category->id)
            ->get();
    }

    /**
     * Returns category by slug
     * @return Category
     */
    public function getCategory()
    {
        return Category::where('slug', $this->categorySlug())
            ->first();
    }
}