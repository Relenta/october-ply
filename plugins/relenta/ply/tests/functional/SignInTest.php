<?php namespace Relenta\Ply\Tests\Functional;

/**
 * Test opens /account page,
 * creates new user, logouts and then signs in
 */
class SignInTest extends TestCase {

    public function testSignIn()
    {
        /* register */
        $this->driver->get($this->getTestPageUrl('/account'));
        $this->registerUser();
        $this->waitUntilRedirectToIndex();
        $this->logoutUser();

        /* login */
        $this->driver->get($this->getTestPageUrl('/account'));
        $this->signInUser();
        $this->waitUntilRedirectToIndex();
    }


    
}