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
            "id"    => 2,
            "data"  => "Cardside data",
        ]);

        $this->assertEquals(2, $cardSide->id);

        $fetched = Cardside::find($cardSide->id);

        $this->assertEquals($cardSide->id, $fetched->id);
        $this->assertEquals("Cardside data", $fetched->data);

        $this->enableForeignKeys();
    }
}
