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
        ];

        $this->disableForeignKeys();

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->enableForeignKeys();
    }
}
