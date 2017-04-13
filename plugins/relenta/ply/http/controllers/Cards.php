<?php

namespace Relenta\Ply\Http\Controllers;

use Relenta\Ply\Models\Card;
use Relenta\Ply\Http\Transformers\CardTransformer;
use Autumn\Api\Classes\ApiController;

class Cards extends ApiController
{
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Card;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new CardTransformer;
    }
}
