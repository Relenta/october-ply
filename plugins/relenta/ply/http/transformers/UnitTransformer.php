<?php

namespace Relenta\Ply\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Relenta\Ply\Models\Unit;

class UnitTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Unit $item)
    {
        return [
            'id'        => (int) $item->id,
            'parent_id' => (int) $item->parent_id,
            'sort'      => (int) $item->sort,
            'title'     => (string) $item->title,
            'data'      => (string) $item->data,
        ];
    }
}
