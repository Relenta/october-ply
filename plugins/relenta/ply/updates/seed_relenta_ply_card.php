<?php namespace Relenta\Ply\Updates;

use Relenta\Ply\Models\Unit;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Seeder;

class SeedRelentaPlyCard extends Seeder
{
    use DisableForeignKeys;

    protected $cardsPerUnit = 10;

    public function run()
    {
        $this->disableForeignKeys();

        $units = Unit::all();

        foreach ($units as $unit) {
            for ($i = 0; $i < $this->cardsPerUnit; $i++) {
                $unit->cards()->create([
                    'card_title'     => $unit->title . ' card #' . $i,
                    'card_data' => $unit->title . ' card #' . $i . ' DATA',
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}
