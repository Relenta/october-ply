<?php
namespace Relenta\Ply\Models\Factories;

use Illuminate\Support\Facades\File;
use October\Rain\Filesystem\Zip;
use Relenta\Ply\Models\Card;
use Relenta\Ply\Models\Category;
use Relenta\Ply\Models\Course;

/**
 * Class CourseFactory
 * Generate course from zip file with predefined structure
 * @package Relenta\Ply\Models\Factories
 */
class CourseFactory
{
    /**
     * File name to search in a zip archive, which contains CardSide related phrases
     * @var string
     */
    protected $csvFileName   = 'phrases.csv';

    /**
     * Minimum value for csv columns count
     * @var integer
     */
    protected $csvMinColumns = 2;

    /**
     * The path of temporary folder for archive extraction
     * @var string
     */
    private $folderPath      = '';

    /**
     * Initialize folderPath with unique descriptor
     */
    public function __construct()
    {
        $this->folderPath = temp_path() . '/unzip_' . uniqid();
    }

    /**
     * @param $name - new course name
     * @param File $zipFile archive with course data
     * @return bool
     */
    public function create($categoryId, $name, $zipFile = '')
    {
        //temp code for testing
        if (empty($zipFile)) {
            $zipFile = storage_path() . '/app/test/valid.zip';
        }

        try {
            File::makeDirectory($this->folderPath);
            Zip::extract($zipFile, $this->folderPath);

            if (!$this->isZipContentValid()) {
                return 'Zip format invalid';
            }

            $newCourse = Category::findOrFail($categoryId)->courses()->create([
                'title' => $name,
            ]);
            $this->createCourseData($newCourse);
        } catch (Exception $e) {
            die('Error when creating course from zip file');
        } finally {
            if (File::exists($this->folderPath)) {
                File::deleteDirectory($this->folderPath);
            }
        }
    }

    /**
     * Create Course with it's relations based on given valid data from zip file
     * @param  Course $newCourse course instance to bind
     * @return bool returns true on successful completion
     */
    private function createCourseData(Course $newCourse)
    {
        $csvFile = $this->getCsvFilePath($this->folderPath);

        $fileHandle = fopen($csvFile, 'r');

        $rowIndex = 1;
        while (!feof($fileHandle)) {
            $rowArray = fgetcsv($fileHandle, 1024);

            $card = Card::make([
                'title'   => 'Card ' . $rowIndex,
                'data'    => 'DATA',
                'unit_id' => null,
                'sort'    => $rowIndex,
            ]);
            $newCourse->cards()->save($card);

            for ($i = 1; $i < count($rowArray); $i++) {
                $mediaFilePath = $this->folderPath . '/' . $i . '/' . $rowIndex . '.mp3';
                $card->sides()->create([
                    'data'   => $rowArray[$i],
                    'media'  => $mediaFilePath,
                    'number' => $i,
                ]);
            }

            $rowIndex++;
        }
        fclose($fileHandle);

        return true;
    }

    /**
     * Validate content of passed zip file for matching predefined rules
     * @return boolean validation status
     */
    private function isZipContentValid()
    {
        $csvFile = $this->getCsvFilePath($this->folderPath);

        $fileHandle = fopen($csvFile, 'r');
        $rowIndex   = 1;

        while (!feof($fileHandle)) {
            $rowArray = fgetcsv($fileHandle, 1024);
            if (!$this->isCsvRowValid($rowArray, $rowIndex)) {
                return false;
            }
            $rowIndex++;
        }
        fclose($fileHandle);

        return true;
    }

    /**
     * Validate csv row to match predefined rules
     * @param  array   $rowArray array of columns from csv row
     * @param  int     $rowIndex index of currently validated row (starts from 1)
     * @return boolean is row valid
     */
    private function isCsvRowValid(array $rowArray, int $rowIndex)
    {
        if (count($rowArray) < $this->csvMinColumns) {
            return false;
        }

        for ($i = 1; $i < count($rowArray); $i++) {
            $mediaFilePath = $this->folderPath . '/' . $i . '/' . $rowIndex . '.mp3';
            if (!File::exists($mediaFilePath)) {
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
            throw new FileNotFoundException($csvFile);
        }

        return $csvFile;
    }
}
