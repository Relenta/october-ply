<?php namespace Relenta\Ply\Tests\Unit\Models;

use PluginTestCase;
use Relenta\Ply\Models\CardSide;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class CardSideTest extends PluginTestCase
{
    use DisableForeignKeys;

    public function testCardsideCreated()
    {
        $this->disableForeignKeys();
        CardSide::truncate();

        $cardSide = CardSide::create([
            "id"    => 2,
            "content"  => "CardSide content",
        ]);

        $this->assertEquals(2, $cardSide->id);

        $fetched = CardSide::find($cardSide->id);

        $this->assertEquals($cardSide->id, $fetched->id);
        $this->assertEquals("CardSide content", $fetched->content);

        $this->enableForeignKeys();
    }
}
