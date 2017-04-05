<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Category;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Seeder;

class SeedRelentaPlyCourse extends Seeder
{
    use DisableForeignKeys;

    protected $coursesPerCategory = 10;

    public function run()
    {
        $categories = Category::where('parent_id', '!=', '0')->get();
        foreach ($categories as $category) {
            for ($i = 0; $i < $this->coursesPerCategory; $i++) {
                $category->courses()->create([
                    'course_title' => $category->category_title . ' child course #' . $i,
                    'lang'         => 'en',
                    'course_data'  => $category->category_title . ' child course #' . $i . ' DATA',
                ]);
            }

        }
    }
}
