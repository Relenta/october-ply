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
                'id'    => 1,
                'title' => 'Languages',
            ],
            [
                'id'    => 2,
                'title' => 'Math',
            ],
            [
                'id'    => 3,
                'title' => 'Computer science',
            ],
            [
                'parent_id'      => 1,
                'title' => 'English for beginners',
            ],
            [
                'parent_id'      => 1,
                'title' => 'Intermediate English',
            ],
            [
                'parent_id'      => 1,
                'title' => 'English for Spanish speakers',
            ],
            [
                'parent_id'      => 2,
                'title' => 'Math for beginners',
            ],
            [
                'parent_id'      => 2,
                'title' => 'Euclidean geometry',
            ],
            [
                'parent_id'      => 2,
                'title' => 'Discrete mathematics',
            ],
            [
                'parent_id'      => 3,
                'title' => 'Database design',
            ],
            [
                'parent_id'      => 3,
                'title' => 'Learning Javascript',
            ],
            [
                'parent_id'      => 3,
                'title' => 'PHP language constructions',
            ],
        ];

        $this->disableForeignKeys();

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->enableForeignKeys();
    }
}
