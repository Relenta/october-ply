<?php

namespace Relenta\Ply\Http\Controllers;

use Relenta\Ply\Models\Category;
use Relenta\Ply\Http\Transformers\CategoryTransformer;
use Autumn\Api\Classes\ApiController;

class Categories extends ApiController
{
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Category;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new CategoryTransformer;
    }
}
