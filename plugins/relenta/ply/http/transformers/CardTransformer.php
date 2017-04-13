<?php

namespace Relenta\Ply\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Relenta\Ply\Models\Card;

class CardTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Card $item)
    {
        return [
            'id'    => (int) $item->id,
            'type'  => (int) $item->type,
            'sort'  => (int) $item->sort,
            'title' => (string) $item->title,
            'data'  => (string) $item->data,
        ];
    }
}
