<?php namespace Relenta\Ply\Tests\Unit\Models;

use PluginTestCase;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class CategoryTest extends PluginTestCase
{
    use DisableForeignKeys;

    public function testCategoryCreated()
    {
        $this->disableForeignKeys();
        Category::truncate();

        $category = Category::create([
            "id"    => 2,
            "title" => "Test category",
        ]);

        $this->assertEquals(2, $category->id);

        $fetched = Category::find($category->id);

        $this->assertEquals($category->id, $fetched->id);

        $this->enableForeignKeys();
    }

    public function testUpdateCourseRelation()
    {
        $this->disableForeignKeys();
        Category::truncate();
        Course::truncate();

        $category = Category::create([
            "id"    => 2,
            "title" => "Test category",
        ]);

        $course = Course::create([
            "id"    => 2,
            "title" => "Test course"
        ]);

        $this->enableForeignKeys();

        $this->assertNull($category->courses()->first());

        $category->courses()->add($course);

        $this->assertNotNull($category->courses()->first());

        $category->courses()->remove($course);

        $this->assertNull($category->courses()->first());
    }

    public function testCreateCourseRelation()
    {
        $this->disableForeignKeys();
        Category::truncate();
        Course::truncate();

        $category = Category::create([
            "id"    => 2,
            "title" => "Test category",
        ]);

        $course = Course::make([
            "id"    => 2,
            "title" => "Test course"
        ]);

        $course->author_id = 1;

        $this->enableForeignKeys();

        $this->assertNull($category->courses()->first());

        $category->courses()->add($course);

        $this->assertNotNull($category->courses()->first());

        $category->courses()->remove($course);

        $this->assertNull($category->courses()->first());
    }
}
