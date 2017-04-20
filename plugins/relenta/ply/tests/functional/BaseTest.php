<?php namespace Relenta\Ply\Tests\Functional;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;

class BaseTest extends TestCase {


    public function testIndex()
    {
        $this->driver->get($this->getTestPageUrl());
		try {
			$meta = $this->getElement(\WebDriverBy::cssSelector('meta[name="author"]'));
			if(!is_null($meta)) {
				$this->assertContains('relenta', $meta->getAttribute('content'), null, true);
			}
		}
		catch(Exception $e) {
		
		}
    }

    public function testExample()
    {
	/*
        $this->driver->get($this->url . '/search');
        // find search field by its id
        $search = $this->driver->findElement(\WebDriverBy::cssSelector('.input-block'));
        $search->click();
        // typing into field
        $this->driver->getKeyboard()->sendKeys('october-ply');
        // pressing "Enter"
        $this->driver->getKeyboard()->pressKey(\WebDriverKeys::ENTER);
        $firstResult = $this->driver->findElement(
            // select link for php-webdriver
            \WebDriverBy::partialLinkText('Relenta')
        );
        $firstResult->click();
        // we expect that facebook/php-webdriver was the first result
        $this->assertContains("Relenta/october-ply",$this->driver->getTitle());
        $this->assertEquals('https://github.com/Relenta/october-ply', $this->driver->getCurrentURL());
        $this->assertElementNotFound(\WebDriverBy::className('name'));
    */
    }

}