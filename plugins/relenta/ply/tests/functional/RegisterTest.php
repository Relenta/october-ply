<?php namespace Relenta\Ply\Tests\Functional;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

/**
 * Test opens /account page,
 * creates new user and logouts
 */
class RegisterTest extends TestCase {

    public function testRegister()
    {
        $this->driver->get($this->getTestPageUrl('/account'));
        $this->fillRegisterForm();
        $this->waitUntilRedirectToIndex();
        $this->logoutUser();
    }

    /** HELPERS */

    private function fillRegisterForm()
    {
        $this
            ->driver
            ->findElement(
                WebDriverBy::id("registerEmail"))
            ->sendKeys($this->user_email);

        $this
            ->driver
            ->findElement(
                WebDriverBy::id("registerPassword"))
            ->sendKeys($this->user_password)
            ->sendKeys(WebDriverKeys::ENTER);
    }


}