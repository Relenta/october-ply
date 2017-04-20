<?php namespace Relenta\Ply\Tests\Functional;

class TestCase extends \PHPUnit_Framework_TestCase {

    protected $url = 'http://localhost:8080';
    /** @var RemoteWebDriver $driver */
    public $driver;
    /** @var bool Indicate whether WebDriver should be created on setUp */
    protected $createWebDriver = true;
    /** @var string */
    protected $serverUrl = 'http://localhost:4444/wd/hub';
	protected $testBaseUrl  = 'http://localhost:8080';
    /** @var DesiredCapabilities */
    protected $desiredCapabilities;
    protected function setUp()
    {
        $this->desiredCapabilities = new \DesiredCapabilities();
        if ($this->isSauceLabsBuild()) {
            $this->setUpSauceLabs();
        } else {
            if (getenv('BROWSER_NAME')) {
                $browserName = getenv('BROWSER_NAME');
            } 
			else {
                $browserName = \WebDriverBrowserType::HTMLUNIT;
            }
            $this->desiredCapabilities->setBrowserName($browserName);
        }
		if (getenv('APP_TEST_URL')) {
            $this->testBaseUrl = getenv('APP_TEST_URL');
        } 
		
        if ($this->createWebDriver) {
            $this->driver = \RemoteWebDriver::create($this->serverUrl, $this->desiredCapabilities);
        }
    }
	
	protected function tearDown()
    {
		if ($this->driver instanceof \RemoteWebDriver && $this->driver->getCommandExecutor()) {
            try {
                $this->driver->quit();
            } catch (\NoSuchWindowException $e) {
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
        if (getenv('TRAVIS_JOB_NUMBER')) {
            $this->desiredCapabilities->setCapability('tunnel-identifier', getenv('TRAVIS_JOB_NUMBER'));
            $this->desiredCapabilities->setCapability('build', getenv('TRAVIS_JOB_NUMBER'));
        }
    }
	
	
	protected function getElement($by)
    {
        $els = $this->driver->findElements($by);
        if (count($els)) {
            return reset($els);
        }
        return null;
    }
	
    /**
     * @var \RemoteWebDriver
     */
    protected function assertElementNotFound($by)
    {
        $els = $this->driver->findElements($by);
        if (count($els)) {
            $this->fail("Unexpectedly element was found");
        }
        // increment assertion counter
        $this->assertTrue(true);
    }


}