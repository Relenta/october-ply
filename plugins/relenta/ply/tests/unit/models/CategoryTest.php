<?php namespace Relenta\Ply\Tests\Unit\Models;

use PluginTestCase;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class CategoryTest extends PluginTestCase
{
    use DisableForeignKeys;

    public function testCategoryCreated()
    {
        $this->disableForeignKeys();
        Category::truncate();

        $category = Category::create([
            "category_id"    => 2,
            "category_title" => "Test category",
        ]);

        $this->assertEquals(2, $category->category_id);

        $fetched = Category::find($category->category_id);

        $this->assertEquals($category->category_id, $fetched->category_id);

        $this->enableForeignKeys();
    }
}
