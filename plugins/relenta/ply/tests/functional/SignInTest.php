<?php namespace Relenta\Ply\Tests\Functional;

//use Db;
use RainLab\User\Plugin;
use RainLab\User\Facades\Auth;
use RainLab\User\Models\User;

class SignInTest extends TestCase {

    /*
     * User to check signing
     */
    protected $user;

    protected $TEST_USER_EMAIL;
    protected $TEST_USER_PASSWORD = 'test_user_password';

    protected function setUp()
    {
        parent::setUp();
        $this->TEST_USER_EMAIL = 'test_user'.uniqid().'@test.com';

        Auth::register([
            'email'                 => $this->TEST_USER_EMAIL,
            'password'              => $this->TEST_USER_PASSWORD,
            'password_confirmation' => $this->TEST_USER_PASSWORD
        ]);

    }

    protected function tearDown()
    {
        //Db::table('users')
        //    ->where('email', $this->TEST_USER_EMAIL)
        //    ->delete();

        User::findByEmail($this->TEST_USER_EMAIL)->delete();

        parent::tearDown();
    }

    /**
     * Test opens /account page, logs in test user, then
     * logouts.
     * @return Void
     */
    public function testSignIn()
    {
        $this->driver->get($this->testBaseUrl.'/account');

        /**
         * Input user email
         */
        $this->driver->findElement(\WebDriverBy::id("userSigninEmail"))
            ->sendKeys($this->TEST_USER_EMAIL);


        /**
         * Input user password
         */
        $this->driver->findElement(\WebDriverBy::id("userSigninPassword"))
            ->sendKeys($this->TEST_USER_PASSWORD)
            ->sendKeys(\WebDriverKeys::ENTER);

        /**
         * Wait and check if we logged
         */
        $driver = $this->driver;
        $url = $this->testBaseUrl;
        
        $this->driver->wait(10, 500)->until(
            function () use ($url, $driver) {
                return $url === $driver->getCurrentURL();
            }, 'Reloading not finished, or something went wrong'
        );

        $this->driver->findElement(\WebDriverBy::id("logout"))->click();
    }



}