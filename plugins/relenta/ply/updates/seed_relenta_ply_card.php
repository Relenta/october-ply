<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Unit;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Faker;
use Seeder;

class SeedRelentaPlyCard extends Seeder
{
    use DisableForeignKeys;

    protected $cardsPerUnit = 3;

    public function run()
    {
        $this->disableForeignKeys();
        $faker = Faker\Factory::create();

        $units = Unit::all();

        foreach ($units as $unit) {
            for ($i = 0; $i < $this->cardsPerUnit; $i++) {
                $unit->cards()->create([
                    'title'     => $faker->sentence($nbWords = rand(1, 4), $bool = true),
                    'data'      => $faker->sentence($nbWords = rand(1, 4), $bool = true),
                    'course_id' => $unit->course->id
                ]);
            }
        }


        $courses = Course::has('units', '<', 1)->get();

        foreach ($courses as $course) {
            for ($i = 0; $i < $this->cardsPerUnit; $i++) {
                $course->cards()->create([
                    'title'     => $faker->sentence($nbWords = rand(1, 4), $bool = true),
                    'data'      => $faker->sentence($nbWords = rand(1, 4), $bool = true)
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}
