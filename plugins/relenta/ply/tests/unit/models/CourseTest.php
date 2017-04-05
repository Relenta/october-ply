<?php namespace Relenta\Ply\Tests\Unit\Models;

use Carbon\Carbon;
use PluginTestCase;
use Relenta\Ply\Models\Course;

class CourseTest extends PluginTestCase
{
    public function testCourseCreated()
    {
        $course = Course::create([
            "course_id"    => 2,
            "course_title" => "Test course",
            "created_at"   => Carbon::now(),
            "updated_at"   => Carbon::now(),
        ]);

        $this->assertEquals(2, $course->course_id);
        $course->save();
        $fetched = Course::find($course->course_id);
        $this->assertEquals($course->course_id, $fetched->course_id);
    }
}
