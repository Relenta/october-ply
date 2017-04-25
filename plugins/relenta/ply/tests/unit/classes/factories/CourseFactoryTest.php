<?php namespace Relenta\Ply\Tests\Unit\Classes\Factories;

use PluginTestCase;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\CardSide;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Classes\Factories\CourseFactory;
use Relenta\Ply\Models\Unit;

class CourseFactoryTest extends PluginTestCase
{
    private $category;
    private $courseFactory;
    private $testFilesDir;

    public function setUp()
    {
        parent::setUp();
        Category::truncate();
        Course::truncate();
        Unit::truncate();
        Card::truncate();
        CardSide::truncate();

        $this->category = Category::create([
            "id"        => 1,
            "title"     => "Test category",
            "parent_id" => null,
        ]);

        $this->courseFactory = new CourseFactory();

        $this->testFilesDir = dirname(__FILE__) . '/files/';
    }

    public function tearDown()
    {
        $this->category->forceDelete();
        $this->courseFactory = null;
    }

    public function testCourseCreated()
    {
        $testZipPath = $this->testFilesDir . 'valid.zip';
        $newCourse   = $this->courseFactory->create($this->category->id, 'Test course from valid zip', $testZipPath);
        $this->assertInstanceOf(Course::class, $newCourse);
        $this->assertEquals($newCourse->cards()->count(), 20);
        $this->assertEquals(CardSide::all()->count(), 40);
    }

    /**
     * @dataProvider zipFileProvider
     */
    public function testInvalidZip($testZipFile)
    {
        $testZipPath = $this->testFilesDir . $testZipFile;
        $newCourse   = $this->courseFactory->create($this->category->id, 'Test course from invalid zip', $testZipPath);
        $this->assertEmpty(Course::all());
        $this->assertEmpty(Unit::all());
        $this->assertEmpty(Card::all());
        $this->assertEmpty(CardSide::all());
        $this->assertNull($newCourse);
    }

    public function zipFileProvider()
    {
        return [
            ['invalid_missed_csv.zip'],
            ['invalid_missed_media.zip'],
        ];
    }
}
