<?php
namespace Relenta\Ply\Classes\Factories;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use October\Rain\Filesystem\Zip;
use RainLab\User\Facades\Auth;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Models\Course;
use Relenta\Ply\Models\Unit;

/**
 * Class CourseFactory
 * Generate course from zip file with predefined structure
 * @package Relenta\Ply\Models\Factories
 */
class CourseFactory
{
    /**
     * Count of cards per unit
     * @var integer
     */
    protected $unitCardsCount = 10;

    /**
     * File name to search in a zip archive, which contains CardSide related phrases
     * @var string
     */
    protected $csvFileName = 'phrases.csv';

    /**
     * Minimum value for csv columns count
     * @var integer
     */
    protected $csvMinColumns = 2;

    /**
     * The path of temporary folder for archive extraction
     * @var string
     */
    private $folderPath = '';

    /**
     * Initialize folderPath with unique descriptor
     */
    public function __construct()
    {
        $this->folderPath = temp_path() . '/unzip_' . uniqid();
    }

    /**
     * @param $author new course author
     * @param $name new course name
     * @param File $zipFile archive with course data
     * @return Course instance of a newly created course or null if failed
     */
    public function create($author, $categoryId, $name, $zipFile = '')
    {
        try {
            File::makeDirectory($this->folderPath);
            Zip::extract($zipFile, $this->folderPath);
            Log::info('Zip content exracted');

            if (!$this->isZipContentValid()) {
                Log::error('Zip content invalid');
                return null;
            }
            Log::info('Zip content validated');

            $newCourse = Course::make([
                'title' => $name
            ]);

            $newCourse->author()->add($author);

            Category::findOrFail($categoryId)->courses()->save($newCourse);

            $this->createCourseData($newCourse);

            return $newCourse;
        } catch (Exception $e) {
            return null;
        } finally {
            if (File::exists($this->folderPath)) {
                File::deleteDirectory($this->folderPath);
            }
        }
    }

    /**
     * Crete unit within course
     * @param  [type] $course parent Course instance
     * @param  [type] $id     descriptive unit identifier
     * @return [type]         created Unit instance
     */
    private function createCourseUnit($course, $id) {
        $courseUnit = $course->units()->create([
            "title" => "Unit #{$id}",
            "data"  => "Unit #{$id} data"
        ]);

        return $courseUnit;
    }

    /**
     * Create Course with it's relations based on given valid data from zip file
     * @param  Course $newCourse course instance to bind
     * @return bool returns true on successful completion
     */
    private function createCourseData(Course $newCourse)
    {
        $csvFilePath = $this->getCsvFilePath($this->folderPath);

        $csvArr = file($csvFilePath);

        $unitCounter = 1;

        if(count($csvArr) <= $this->unitCardsCount) {
            $cardHolder = $newCourse;
        } else {
            $cardHolder = $this->createCourseUnit($newCourse, $unitCounter);
        }

        foreach ($csvArr as $rowIndex => $line) {
            $cardIndex = $rowIndex;
            $rowArr    = str_getcsv($line);

            $sizeLimiter = floor(($cardIndex + 1) / $this->unitCardsCount);
            if($sizeLimiter >= $unitCounter) {
                $unitCounter++;
                $cardHolder = $this->createCourseUnit($newCourse, $unitCounter);
            }

            $card = Card::make([
                'title'   => 'Card ' . $cardIndex,
                'data'    => 'DATA',
                'course_id' => $newCourse->id,
                'sort'    => $cardIndex,
            ]);

            $cardHolder->cards()->save($card);

            for ($i = 1; $i < count($rowArr); $i++) {
                $mediaFilePath = $this->folderPath . '/' . $i . '/' . $cardIndex . '.mp3';
                $card->sides()->create([
                    'content' => $rowArr[$i],
                    'media'   => $mediaFilePath,
                    'number'  => $i,
                ]);
            }
        }

        return true;
    }

    /**
     * Validate content of passed zip file for matching predefined rules
     * @return boolean validation status
     */
    private function isZipContentValid()
    {
        $csvFilePath = $this->getCsvFilePath($this->folderPath);
        if (!$csvFilePath) {
            Log::error('Zip file content not found at path specified');
            return false;
        }

        $csvArr = file($csvFilePath);
        foreach ($csvArr as $rowIndex => $line) {
            $rowArr = str_getcsv($line);
            if (!$this->isCsvRowValid($rowArr, $rowIndex)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate csv row to match predefined rules
     * @param  array   $rowArray array of columns from csv row
     * @param  int     $rowIndex index of currently validated row (starts from 1)
     * @return boolean is row valid
     */
    private function isCsvRowValid($rowArray, $rowIndex)
    {
        if (count($rowArray) < $this->csvMinColumns) {
            Log::error('Zip file row count not match minimal count');
            return false;
        }

        for ($i = 1; $i < count($rowArray); $i++) {
            $mediaFilePath = $this->folderPath . '/' . $i . '/' . $rowIndex . '.mp3';
            if (!File::exists($mediaFilePath)) {
                Log::error("Zip content row #{$rowIndex} in folder {$i} doesn't have media file attached");
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if csv file with phrases exists in extracted folder and return path to it.
     * Otherwise thro
     * @return string csv file absolute path
     * @throws FileNotFoundException if csv file with phrases not found
     */
    private function getCsvFilePath()
    {
        $csvFile = $this->folderPath . '/' . $this->csvFileName;

        if (!File::exists($csvFile)) {
            return false;
        }

        return $csvFile;
    }
}
