<?php namespace Relenta\Ply\Tests\Functional;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Facebook\WebDriver\Exception\StaleElementReferenceException;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;

class TestCase extends \PHPUnit_Framework_TestCase {

    protected $url = 'http://localhost:8080';

    /** @var RemoteWebDriver $driver */
    public $driver;

    /** @var bool Indicate whether WebDriver should be created on setUp */
    protected $createWebDriver = true;

    /** @var string */
    protected $serverUrl = 'http://136.169.60.130:4444/wd/hub';

    protected $testBaseUrl  = 'http://localhost:8080';

    /** @var DesiredCapabilities */
    protected $desiredCapabilities;

    public $user_email;
    public $user_password = 'test_user_password';

    protected function setUp()
    {
	    $browserName = WebDriverBrowserType::HTMLUNIT;
        $this->desiredCapabilities = new DesiredCapabilities();
        if ($this->isSauceLabsBuild()) {
            $this->setUpSauceLabs();
        }
        else {
            if (getenv('BROWSER_NAME')) {
                $browserName = getenv('BROWSER_NAME');
            } 
			else {
                $browserName = WebDriverBrowserType::HTMLUNIT;
            }
            $this->desiredCapabilities->setBrowserName($browserName);
        }

        if (getenv('APP_TEST_URL')) {
            $this->testBaseUrl = getenv('APP_TEST_URL');
        }

        if (getenv('SELENIUM_SERVER_URL')) {
            $this->serverUrl = getenv('SELENIUM_SERVER_URL');
        }

        if ($this->createWebDriver) {
            $this->driver = RemoteWebDriver::create($this->serverUrl, $this->desiredCapabilities);
        }

        $this->generateUserEmail();
    }
	
	protected function tearDown()
    {
		if ($this->driver instanceof RemoteWebDriver && $this->driver->getCommandExecutor())
        {
            try
            {
                $this->driver->quit();
            } catch (NoSuchWindowException $e)
            {
                // browser may have died or is already closed
            }
        }
    }
    
    /**
     * @return bool
     */
    public function isSauceLabsBuild()
    {
        return getenv('SAUCELABS') ? true : false;
    }

    /**
     * Get the URL of given test HTML on running webserver.
     *
     * @param string $path
     * @return string
     */
    protected function getTestPageUrl($path = '')
    {
        return $this->testBaseUrl.$path;
    }
	
    protected function setUpSauceLabs()
    {
        $this->serverUrl = sprintf(
            'http://%s:%s@ondemand.saucelabs.com/wd/hub',
            getenv('SAUCE_USERNAME'),
            getenv('SAUCE_ACCESS_KEY')
        );

        $this->desiredCapabilities->setBrowserName(getenv('BROWSER_NAME'));
        $this->desiredCapabilities->setVersion(getenv('VERSION'));
        $this->desiredCapabilities->setPlatform(getenv('PLATFORM'));
        $this->desiredCapabilities->setCapability('name', get_class($this) . '::' . $this->getName());
        $this->desiredCapabilities->setCapability('tags', [get_class($this)]);

        if (getenv('TRAVIS_JOB_NUMBER'))
        {
            $this->desiredCapabilities->setCapability('tunnel-identifier', getenv('TRAVIS_JOB_NUMBER'));
            $this->desiredCapabilities->setCapability('build', getenv('TRAVIS_JOB_NUMBER'));
        }
    }
	
	
	protected function getElement($by)
    {
        $els = $this->driver->findElements($by);
        if (count($els))
        {
            return reset($els);
        }

        return null;
    }
	
    /**
     * @var RemoteWebDriver
     */
    protected function assertElementNotFound($by)
    {
        $els = $this->driver->findElements($by);
        if (count($els))
        {
            $this->fail("Unexpectedly element was found");
        }

        // increment assertion counter
        $this->assertTrue(true);
    }

    protected function generateUserEmail() {
        $this->user_email = 'test_user'.uniqid().'@test.com';
    }

    /**
     * Try to find navigation menu and logout. While construction
     * is needed bacause of DOM-refreshing, and driver
     * can`t handle it so faster as browser.
     * For documentation on this error, please visit:
     * 1. http://seleniumhq.org/exceptions/stale_element_reference.html
     * 2. https://github.com/facebook/php-webdriver/issues/232
     */
    protected function logoutUser()
    {
        $account_dropdown   = 'nav .account-nav-dropdown';
        $logout_id          = 'logout';

        while(true)
        {
            try
            {
                $this->driver
                    ->findElement(WebDriverBy::cssSelector($account_dropdown))
                    ->click();

                break;
            }
            catch(StaleElementReferenceException $ex) {}
        }

        $this->driver->wait(10, 1000)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id($logout_id))
        );

        $this->driver
            ->findElement(WebDriverBy::id($logout_id))
            ->click();
    }


    protected function waitUntilRedirectToIndex()
    {
        $driver = $this->driver;
        $url    = $this->getTestPageUrl();

        $this->driver->wait(10, 1000)->until(
            WebDriverExpectedCondition::urlIs('/')
        );
    }

}
