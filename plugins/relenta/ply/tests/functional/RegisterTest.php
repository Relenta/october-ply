<?php namespace Relenta\Ply\Tests\Functional;

/**
 * Test opens /account page,
 * creates new user and waits page loading
 */
class RegisterTest extends TestCase {

    public function testRegister()
    {
        $this->driver->get($this->getTestPageUrl('/account'));
        $this->registerUser();
        $this->waitUntilRedirectToIndex();
    }
}