<?php

namespace Relenta\Ply\Http\Controllers;

use Relenta\Ply\Models\Course;
use Relenta\Ply\Http\Transformers\CourseTransformer;
use Autumn\Api\Classes\ApiController;

class Courses extends ApiController
{
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Course;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new CourseTransformer;
    }
}
