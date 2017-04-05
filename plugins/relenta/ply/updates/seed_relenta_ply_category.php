<?php namespace Relenta\Ply\Updates;

use Illuminate\Support\Facades\DB;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Seeder;

class SeedRelentaPlyCategory extends Seeder
{

    use DisableForeignKeys;

    public function run()
    {
        $categories = [
            [
                'category_id'    => 1,
                'category_title' => 'Languages',
            ],
            [
                'category_id'    => 2,
                'category_title' => 'Math',
            ],
            [
                'category_id'    => 3,
                'category_title' => 'Computer science',
            ],
            [
                'parent_id'      => 1,
                'category_title' => 'English for beginners',
            ],
            [
                'parent_id'      => 1,
                'category_title' => 'Intermediate English',
            ],
            [
                'parent_id'      => 1,
                'category_title' => 'English for Spanish speakers',
            ],
            [
                'parent_id'      => 2,
                'category_title' => 'Math for beginners',
            ],
            [
                'parent_id'      => 2,
                'category_title' => 'Euclidean geometry',
            ],
            [
                'parent_id'      => 2,
                'category_title' => 'Discrete mathematics',
            ],
            [
                'parent_id'      => 3,
                'category_title' => 'Database design',
            ],
            [
                'parent_id'      => 3,
                'category_title' => 'Learning Javascript',
            ],
            [
                'parent_id'      => 3,
                'category_title' => 'PHP language constructions',
            ],
        ];

        $this->disableForeignKeys();

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->enableForeignKeys();
    }
}
