<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Card;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Seeder;

class SeedRelentaPlyCardside extends Seeder
{
    use DisableForeignKeys;

    protected $sidesPerCard = 2;

    public function run()
    {
        $this->disableForeignKeys();

        $cards = Card::all();

        foreach ($cards as $card) {
            for ($i = 1; $i <= $this->sidesPerCard; $i++) {
                $card->sides()->create([
                    'number' => $i,
                    'content'  => $card->title . ' side #' . $i . ' CONTENT',
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}
