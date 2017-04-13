<?php

namespace Relenta\Ply\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Relenta\Ply\Models\CardSide;

class CardSideTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(CardSide $item)
    {
        return [
            'id'     => (int) $item->id,
            'number' => (int) $item->number,
            'data'   => (string) $item->data,
        ];
    }
}
