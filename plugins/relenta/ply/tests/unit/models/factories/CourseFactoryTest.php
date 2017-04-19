<?php namespace Relenta\Ply\Tests\Unit\Models\Factories;

use PluginTestCase;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Traits\Database\DisableForeignKeys;

class CourseFactoryTest extends PluginTestCase
{
    public function testCourseCreated()
    {
        return true;
    }

    public function tesUnitsCreated()
    {
        return true;
    }

    public function testCardsCreated()
    {
        return true;
    }

    public function testInvalidZipMissedPhrase()
    {
        return true;
    }

    public function testInvalidZipMissedCsv()
    {
        return true;
    }

    public function testInvalidZipMissedMediaFile()
    {
        return true;
    }

    public function testZipFileNotFound()
    {
        return true;
    }
}
