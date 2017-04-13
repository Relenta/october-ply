<?php

namespace Relenta\Ply\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Relenta\Ply\Models\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Category $item)
    {
        return [
            'id'        => (int) $item->id,
            'parent_id' => (int) $item->parent_id,
            'title'     => (string) $item->title,
            'sort'      => (string) $item->sort,
        ];
    }
}
