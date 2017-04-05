<?php namespace Relenta\Ply\Tests\Unit\Models;

use Carbon\Carbon;
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
            "course_id"    => 2,
            "course_title" => "Test course",
            "updated_at"   => Carbon::now(),
            "created_at"   => Carbon::now(),
        ]);

        $this->assertEquals(2, $course->course_id);

        $course->save();

        $fetched = Course::find($course->course_id);
        $this->assertEquals($course->course_id, $fetched->course_id);

        $this->enableForeignKeys();
    }

    public function testGuardedAuthor()
    {
        $course = Course::make(['author_id' => 2, "course_title" => "Test guarded author_id field"]);

        $this->assertNull($course->author_id);
    }
}
