<?php namespace Relenta\Ply\Tests\Functional;

//use RainLab\User\Plugin;
//use RainLab\User\Models\User;

class RegisterTest extends TestCase {

    /*
     * Variables for user creation
     */
    protected $TEST_USER_EMAIL;
    protected $TEST_USER_PASSWORD = 'test_user_password';

    protected function setUp()
    {
        parent::setUp();

        $this->TEST_USER_EMAIL = 'test_user'.uniqid().'@test.com';
    }

    protected function tearDown()
    {
        \Db::table('users')
            ->where('email', $this->TEST_USER_EMAIL)
            ->delete();

        parent::tearDown();
    }

    /**
     * Test opens /account page, and creates new user, then
     * logouts.
     * @return Void
     */
    public function testRegister()
    {
        $this->driver->get($this->testBaseUrl.'/account');

        /** Input user email */
        $this->driver->findElement(\WebDriverBy::id("registerEmail"))
            ->sendKeys($this->TEST_USER_EMAIL);


        /** Input user password and submit form */
        $this->driver->findElement(\WebDriverBy::id("registerPassword"))
            ->sendKeys($this->TEST_USER_PASSWORD)
            ->sendKeys(\WebDriverKeys::ENTER);

        /** Wait and check if we logged*/
        $driver = $this->driver;
        $url = $this->testBaseUrl;
        
        $this->driver->wait(10, 500)->until(
            $this->driver->wait(10, 500)->until(
                function () use ($url, $driver) {
                    return $url === $driver->getCurrentURL();
                }, 'Reloading not finished, or something went wrong'
            )
        );

        $this->driver->findElement(\WebDriverBy::id("logout"))->click();
    }
}