<?php namespace Relenta\Ply\Tests\Api;

use PluginTestCase;
use GuzzleHttp\Client;

class ApiTestCase extends PluginTestCase {

    protected $client;
    protected $testBaseUrl = 'http://localhost:8080';

    public function setUp()
    {
        if (getenv('APP_TEST_URL')) {
            $this->testBaseUrl = getenv('APP_TEST_URL');
        } 
        $this->client = new Client([
            'base_url' => $this->testBaseUrl,
            'defaults' => ['exceptions' => false]
        ]);
        parent::setUp();
    }

    /**
     * Get the URL of given api path
     *
     * @param string $path
     * @return string
     */
    protected function getTestPageUrl($path = '')
    {
        return $this->testBaseUrl.$path;
    }

}
