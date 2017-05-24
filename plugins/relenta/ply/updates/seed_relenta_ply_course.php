<?php namespace Relenta\Ply\Updates;

use RainLab\User\Models\User;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Faker;
use Seeder;

class SeedRelentaPlyCourse extends Seeder
{
    use DisableForeignKeys;

    protected $coursesPerCategory;

    public function run()
    {
        $faker = Faker\Factory::create();
        $categories = Category::where('parent_id', '!=', '0')->get();

        $course_type = [
            0 => "[With units]",
            1 => "[Without units]",
            2 => "[Nested units]",
        ];


        foreach ($categories as $category) {
            $this->coursesPerCategory = rand(3, 6);

            for ($i = 0; $i < $this->coursesPerCategory; $i++) {

                $type = $course_type[0];

                if(($i + 1) % 3 == 0) {
                    $type = $course_type[2];
                }
                else if (($i + 1) % 2 == 0) {
                    $type = $course_type[1];
                }

                $newCourse = new Course([
                    'title' => $faker->sentence($nbWords = rand(3,6), $variableNbWords = true),
                    'lang'  => 'en',
                    'data'  => $type." ".$faker->text,
                ]);
                $newCourse->author()->associate(User::where('email', 'admin@admin.com')->first());
                $category->courses()->save($newCourse);
            }
        }
    }
}
