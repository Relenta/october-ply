<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Card;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Faker;
use Seeder;

class SeedRelentaPlyCardside extends Seeder
{
    use DisableForeignKeys;

    protected $sidesPerCard = 2;

    public function run()
    {
        $this->disableForeignKeys();
        $faker = Faker\Factory::create();

        $cards = Card::all();

        foreach ($cards as $card) {
            for ($i = 1; $i <= $this->sidesPerCard; $i++) {
                $card->sides()->create([
                    'number'    => $i,
                    'content'   => $faker->sentence($nbWords = rand(1, 4), $bool = true),
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}
