<?php namespace Relenta\Ply\Tests\Unit\Models;

use PluginTestCase;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class CardTest extends PluginTestCase
{
    use DisableForeignKeys;

    public function testCardCreated()
    {
        $this->disableForeignKeys();
        Card::truncate();

        $card = Card::create([
            "card_id"    => 2,
            "card_title" => "Test card",
            "card_data"  => "Card data",
        ]);

        $this->assertEquals(2, $card->card_id);

        $fetched = Card::find($card->card_id);

        $this->assertEquals($card->card_id, $fetched->card_id);
        $this->assertEquals("Test card", $fetched->card_title);
        $this->assertEquals("Card data", $fetched->card_data);

        $this->enableForeignKeys();
    }
}
