<?php

namespace Relenta\Ply\Http\Controllers;

use Relenta\Ply\Models\Unit;
use Relenta\Ply\Http\Transformers\UnitTransformer;
use Autumn\Api\Classes\ApiController;

class Units extends ApiController
{
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Unit;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new UnitTransformer;
    }
}
