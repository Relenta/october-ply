<?php namespace Relenta\Ply\Tests\Functional;

use Relenta\Ply\Tests\Functional\TestCase;

class AccountTest extends TestCase {

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

    /**
     * Test opens /account page, and:
     * 1. Creates new user and logouts
     * 2. Checks error 'User already registered'
     * 3. Signs in
     */
    public function testAccount()
    {
        $this->register();
        $this->handleRegisteredUserError();
        $this->signIn();
    }


    /** TESTS */

    private function register()
    {
        $this->driver->get($this->testBaseUrl.'/account');
        $this->fillRegisterForm();
        $this->waitUntilRedirect();
        $this->logout();
    }

    private function handleRegisteredUserError()
    {
        $this->driver->get($this->testBaseUrl.'/account');
        $this->fillRegisterForm();

        $this->driver
            ->wait(10, 1000)
            ->until(\WebDriverExpectedCondition::alertIsPresent());

        $this->driver->switchTo()->alert()->accept();
    }

    private function signIn()
    {
        $this->driver->get($this->testBaseUrl.'/account');

        $this->driver->findElement(\WebDriverBy::id("userSigninEmail"))
            ->sendKeys($this->TEST_USER_EMAIL);

        $this->driver->findElement(\WebDriverBy::id("userSigninPassword"))
            ->sendKeys($this->TEST_USER_PASSWORD)
            ->sendKeys(\WebDriverKeys::ENTER);

        $this->waitUntilRedirect();
        $this->logout();
    }


    /** HELPERS */

    private function fillRegisterForm()
    {
        $this->driver->findElement(\WebDriverBy::id("registerEmail"))
            ->sendKeys($this->TEST_USER_EMAIL);

        $this->driver->findElement(\WebDriverBy::id("registerPassword"))
            ->sendKeys($this->TEST_USER_PASSWORD)
            ->sendKeys(\WebDriverKeys::ENTER);
    }

    private function waitUntilRedirect()
    {
        $driver = $this->driver;
        $url    = $this->testBaseUrl;

        $this->driver->wait(10, 1000)->until(
            function () use ($driver, $url) {
                return $url.'/' === $driver->getCurrentURL();
            }, 'Reloading not finished, or something went wrong'
        );
    }

    /**
     * Try to find navigation menu and logout. While construction
     * is needed bacause of DOM-refreshing, and driver
     * can`t handle it so faster as browser.
     * For documentation on this error, please visit:
     * 1. http://seleniumhq.org/exceptions/stale_element_reference.html
     * 2. https://github.com/facebook/php-webdriver/issues/232
     */
    private function logout()
    {
        $account_dropdown   = 'nav .account-nav-dropdown';
        $logout_id          = 'logout';

        while(true)
        {
            try
            {
                $this->driver
                    ->findElement(\WebDriverBy::cssSelector($account_dropdown))
                    ->click();

                break;
            }
            catch(\StaleElementReferenceException $ex) {}
        }

        $this->driver->wait(10, 1000)->until(
            \WebDriverExpectedCondition::visibilityOfElementLocated(\WebDriverBy::id($logout_id))
        );

        $this->driver
            ->findElement(\WebDriverBy::id($logout_id))
            ->click();
    }
}