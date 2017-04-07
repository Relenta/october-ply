<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Course;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Seeder;

class SeedRelentaPlyUnit extends Seeder
{
    use DisableForeignKeys;

    protected $unitsPerCourse = 3;

    public function run()
    {
        $this->disableForeignKeys();

        $courses = Course::all();

        foreach ($courses as $course) {
            for ($i = 0; $i < $this->unitsPerCourse; $i++) {
                $course->units()->create([
                    'title' => $course->course_title . ' unit #' . $i,
                    'unit_data'  => $course->course_title . ' unit #' . $i . ' DATA',
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}
