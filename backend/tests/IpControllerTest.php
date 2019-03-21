<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IpControllerTest extends WebTestCase
{
    protected const VALID_IP4 = '81.1.1.1';
    protected const VALID_IP6 = '2001:0db8:11a3:09d7:1f34:8a2e:07a0:765d';
    protected const INVALID_IP4 = '81.1.1.-';
    protected const INVALID_IP6 = '2001:0db8:11a3:09d7:1f34:8a2e:07a0:----';

    public function provideValidIps()
    {
        return [
            [static::VALID_IP4],
            [static::VALID_IP6],
        ];
    }

    public function provideInvalidIps()
    {
        return [
            [static::INVALID_IP4],
            [static::INVALID_IP6],
        ];
    }


    /**
     * @dataProvider provideValidIps
     */
    public function testQueryIpSuccess($ip)
    {
        $client = static::createClient([], ['HTTP_HOST' => 'test.local']);
        $client->request('GET', '/rest/ip/'.$ip);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertJsonStringEqualsJsonString(
            '{"data":{"ip":"'.$ip.'","counter":0}}',
            $client->getResponse()->getContent()
        );
    }

    /**
     * @dataProvider provideInvalidIps
     */
    public function testQueryIpInvalid($ip)
    {
        $client = static::createClient([], ['HTTP_HOST' => 'test.local']);
        $client->request('GET', '/rest/ip/'.$ip);

        $this->assertSame(422, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'This is not a valid IP address',
            $client->getResponse()->getContent()
        );
    }


    /**
     * @dataProvider provideValidIps
     */
    public function testAddIpSuccess($ip)
    {
        $client = static::createClient([], ['HTTP_HOST' => 'test.local']);
        $client->request('PUT', '/rest/ip/'.$ip);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertJsonStringEqualsJsonString(
            '{"data":{"ip":"'.$ip.'","counter":1}}',
            $client->getResponse()->getContent()
        );

        $client->request('PUT', '/rest/ip/'.$ip);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertJsonStringEqualsJsonString(
            '{"data":{"ip":"'.$ip.'","counter":2}}',
            $client->getResponse()->getContent()
        );
    }

    /**
     * @dataProvider provideInvalidIps
     */
    public function testAddIpInvalid($ip)
    {
        $client = static::createClient([], ['HTTP_HOST' => 'test.local']);
        $client->request('PUT', '/rest/ip/'.$ip);

        $this->assertSame(422, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'This is not a valid IP address',
            $client->getResponse()->getContent()
        );
    }
}
