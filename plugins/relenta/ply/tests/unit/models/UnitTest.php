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
            "unit_id"    => 2,
            "title" => "Test unit",
            "unit_data"  => "Unit data",
        ]);

        $this->assertEquals(2, $unit->unit_id);

        $fetched = Unit::find($unit->unit_id);

        $this->assertEquals($unit->unit_id, $fetched->unit_id);
        $this->assertEquals("Test unit", $fetched->title);
        $this->assertEquals("Unit data", $fetched->unit_data);

        $this->enableForeignKeys();
    }
}
