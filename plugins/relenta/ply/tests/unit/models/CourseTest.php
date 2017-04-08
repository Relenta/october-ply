<?php namespace Relenta\Ply\Tests\Unit\Models;

use PluginTestCase;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class CourseTest extends PluginTestCase
{
    use DisableForeignKeys;

    public function testCourseCreated()
    {
        $this->disableForeignKeys();
        Course::truncate();

        $course = Course::create([
            "id"    => 2,
            "title" => "Test course",
        ]);

        $this->assertEquals(2, $course->id);

        $fetched = Course::find($course->id);

        $this->assertEquals($course->id, $fetched->id);

        $this->enableForeignKeys();
    }

    public function testGuardedAuthor()
    {
        $this->disableForeignKeys();
        Course::truncate();

        $course = Course::make(['author_id' => 1, "title" => "Test guarded author_id field"]);

        $this->assertNull($course->author_id);

        $course = Course::create(['author_id' => 2, "title" => "Test guarded author_id field"]);

        $this->assertNull($course->author_id);
        $this->enableForeignKeys();
    }
}
