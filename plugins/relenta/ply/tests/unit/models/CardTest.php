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
            "id"    => 2,
            "title" => "Test card",
            "data"  => "Card data",
        ]);

        $this->assertEquals(2, $card->id);

        $fetched = Card::find($card->id);

        $this->assertEquals($card->id, $fetched->id);
        $this->assertEquals("Test card", $fetched->title);
        $this->assertEquals("Card data", $fetched->data);

        $this->enableForeignKeys();
    }
}
