<?php namespace Relenta\Ply\Tests\Functional;

use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Test opens /account page,
 * creates new user, logouts and tries to
 * create same user. Waits for alert.
 */
class AlreadyRegisteredUserTest extends TestCase {

    public function testAlreadyRegisteredUser()
    {
        $this->runRegistration();
        $this->waitUntilRedirectToIndex();
        $this->logoutUser();
        $this->runRegistration();

        // handle alert
        $this->driver->wait(10, 1000)->until(WebDriverExpectedCondition::alertIsPresent());
        $this->driver->switchTo()->alert()->accept();
    }


    /* HELPERS */

    private function runRegistration() {
        $this->driver->get($this->getTestPageUrl('/account'));
        $this->registerUser();
    }
}