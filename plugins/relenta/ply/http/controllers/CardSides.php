<?php

namespace Relenta\Ply\Http\Controllers;

use Relenta\Ply\Models\CardSide;
use Relenta\Ply\Http\Transformers\CardSideTransformer;
use Autumn\Api\Classes\ApiController;

class CardSides extends ApiController
{
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new CardSide;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new CardSideTransformer;
    }
}
