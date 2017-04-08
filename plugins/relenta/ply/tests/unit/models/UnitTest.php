<?php namespace Relenta\Ply\Tests\Unit\Models;

use PluginTestCase;
use Relenta\Ply\Models\Unit;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class UnitTest extends PluginTestCase
{
    use DisableForeignKeys;

    public function testUnitCreated()
    {
        $this->disableForeignKeys();
        Unit::truncate();

        $unit = Unit::create([
            "id"    => 2,
            "title" => "Test unit",
            "data"  => "Unit data",
        ]);

        $this->assertEquals(2, $unit->id);

        $fetched = Unit::find($unit->id);

        $this->assertEquals($unit->id, $fetched->id);
        $this->assertEquals("Test unit", $fetched->title);
        $this->assertEquals("Unit data", $fetched->data);

        $this->enableForeignKeys();
    }
}
