<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Course;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Faker;
use Seeder;

class SeedRelentaPlyUnit extends Seeder
{
    use DisableForeignKeys;

    protected $unitsPerCourse = 2;
    protected $faker;

    public function run()
    {
        $this->disableForeignKeys();

        $courses = Course::all();
        $this->faker = Faker\Factory::create();

        foreach ($courses as $index => $course) {
            if(($index + 1) % 3 == 0) {
                // Nested units
                $depth          = rand(2, 4);
                $unit_value     = rand(1, 4);
                $parent_units   = [];

                for ($i = 0; $i < $unit_value; $i++) {
                    $parent_units[] = $course->units()->create([
                        'title' => $this->faker->sentence($nbWords = rand(3,6), $variableNbWords = true),
                        'data'  => $this->faker->text,
                    ]);
                }
                $this->createNestedTree($course, $parent_units, $depth);

            }
            else if (($index + 1) % 2 == 0) {
                // Without units
                continue;
            }
            else {
                // With units
                for ($i = 0; $i < $this->unitsPerCourse; $i++) {
                    $unit_value = rand(1, 10);

                    for ($i = 0; $i < $unit_value; $i++) {
                        $course->units()->create([
                            'title' => $this->faker->sentence($nbWords = rand(3,6), $variableNbWords = true),
                            'data'  => $this->faker->text,
                        ]);
                    }
                }
            }
        }

        $this->enableForeignKeys();
    }

    function createNestedTree($course, $parent_units, $depth) {
        $new_parents = [];

        foreach($parent_units as $parent) {
            for ($i = 0; $i < rand(1, 10); $i++) {
                $unit = $course->units()->create([
                    'title' => $this->faker->sentence($nbWords = rand(3,6), $variableNbWords = true),
                    'data'  => $this->faker->text,
                    'parent_id' => $parent->id
                ]);
                $new_parents[] = $unit;
            }
        }

        if ($depth != 1) {
            $this->createNestedTree($course, $new_parents, $depth - 1);
        }
    }
}
