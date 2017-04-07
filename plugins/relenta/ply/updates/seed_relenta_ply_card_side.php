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
                    'side_number' => $i,
                    'side_data'  => $card->card_title . ' side #' . $i . ' DATA',
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}
