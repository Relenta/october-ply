<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use League\Flysystem\Exception;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Models\Factories\CourseFactory;
use Illuminate\Support\Facades\Input;

class CourseUpdate extends ComponentBase
{
    /**
     * A course to update
     * @var Model
     */
    public $course;

    /**
     * A list of categories
     * @var Collection
     */
    public $categories;

    public function componentDetails()
    {
        return [
            'name' => 'GetPly Course Update',
            'description' => 'Displays a form with course.'
        ];
    }

    public function defineProperties()
    {
        return [
            /*'courseIdParam' => [
                'title'             => 'Course Id Parameter',
                'description'       => 'Name of variable, which contains course id',
                'type'              => 'string',
                'required'          => true,
                'validationMessage' => 'Course id parameter is required'
            ]*/
        ];
    }

    public function onRun()
    {
        $this->categories = $this->getCategories();
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function onSubmit() {
        try {
            // Data collect
            $course_name = post("course-name");
            $category_id = post("category");
            $zip_file = Input::file('file-input');

            //dump($course_name);
            //dump($zip_file->getRealPath());
            //dump($category_id);
            //echo phpversion();
            $courseFactory = new CourseFactory();
            $result = $courseFactory->create($category_id, $course_name, $zip_file->getRealPath());
            return $result;
        } catch (Exception $ex) {

            throw $ex;
        }

    }
}