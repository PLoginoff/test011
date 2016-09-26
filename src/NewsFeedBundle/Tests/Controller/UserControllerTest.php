<?php

namespace NewsFeedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testSmoke()
    {
        $urls = ['/register', '/activate', '/login'];
        $client = static::createClient();
        foreach ($urls as $url) {
            $client->request('GET', $url);
            $this->assertTrue($client->getResponse()->isSuccessful());
        }
    }

    public function testPassword()
    {
        $client = static::createClient();
        $client->request('GET', '/password');
        $this->assertTrue($client->getResponse()->isRedirection());
    }

}
