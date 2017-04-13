<?php

namespace Relenta\Ply\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Relenta\Ply\Models\Course;

class CourseTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Course $item)
    {
        return [
            'id'         => (int) $item->id,
            'author_id'  => (int) $item->author_id,
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
            'lang'       => (string) $item->lang,
            'title'      => (string) $item->title,
            'data'       => (string) $item->data,
        ];
    }
}
