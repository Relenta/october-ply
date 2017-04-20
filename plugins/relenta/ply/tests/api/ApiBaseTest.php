<?php namespace Relenta\Ply\Tests\Api;

use PluginTestCase;

class ApiBaseTest extends ApiTestCase
{
    public function testApiResponse()
    {
        $res = $this->client->get($this->getTestPageUrl('/api/v1/cards'), ['auth' =>  ['user', 'pass']]);
        $this->assertEquals(200, $res->getStatusCode());
        
    }
}
