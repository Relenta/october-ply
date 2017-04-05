<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Category;
use Seeder;

class SeedRelentaPlyCourse extends Seeder
{
    public function run()
    {
        $categories = Category::where('parent_id', '!=', '0')->get();
        foreach ($categories as $category) {
            for ($i=0; $i < 5; $i++) { 
                $category->courses()->create([
                    'course_title' => $category->category_title . ' child course #' . $i,
                    'lang' => 'en',
                    'course_data' => $category->category_title . ' child course #' . $i . ' DATA',
                ]);
            }
            
        }
    }
}
