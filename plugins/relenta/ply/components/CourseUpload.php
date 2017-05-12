<?php namespace Relenta\Ply\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ValidationException;
use RainLab\User\Facades\Auth;
use Relenta\Ply\Classes\Factories\CourseFactory;
use Relenta\Ply\Models\Category;

class CourseUpload extends ComponentBase
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

    /**
     * An object with form validation errors
     * @var ValidationException
     */
    public $error;


    public function componentDetails()
    {
        return [
            'name'          => 'relenta.ply::lang.components.course_upload.name',
            'description'   => 'relenta.ply::lang.components.course_upload.description'
        ];
    }

    /**
     * Checks post data and calls CourseFactory::create
     */
    public function onSubmit() {
        try {

            $data = post();
            $data['file-input'] = Input::file('file-input');

            $this->page['submitted_category'] = Category::where("id", $data['category'])->first();
            $this->page['submitted_course_name'] = $data['course-name'];

            $rules = [
                'course-name' => [
                    'required',
                    'min:6',
                    'max:255'
                ],
                'category' => [
                    'required',
                    'numeric'
                ],
                'file-input' => [
                    'required',
                    'mimes:zip'
                ]
            ];

            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            $courseFactory = new CourseFactory();

            $this->course = $this->page['course'] = $courseFactory->create(
                Auth::getUser(),
                $data['category'],
                $data['course-name'],
                $data['file-input']->getRealPath()
            );
        } catch (ValidationException $ex) {
            $this->error = $this->page['error'] = $ex;
        }

    }
}