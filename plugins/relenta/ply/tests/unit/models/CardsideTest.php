<?php namespace Relenta\Ply\Tests\Unit\Models;

use PluginTestCase;
use Relenta\Ply\Models\Cardside;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class CardsideTest extends PluginTestCase
{
    use DisableForeignKeys;

    public function testCardsideCreated()
    {
        $this->disableForeignKeys();
        Cardside::truncate();

        $cardSide = Cardside::create([
            "card_side_id"    => 2,
            "side_data"  => "Cardside data",
        ]);

        $this->assertEquals(2, $cardSide->card_side_id);

        $fetched = Cardside::find($cardSide->card_side_id);

        $this->assertEquals($cardSide->card_side_id, $fetched->card_side_id);
        $this->assertEquals("Cardside data", $fetched->side_data);

        $this->enableForeignKeys();
    }
}
