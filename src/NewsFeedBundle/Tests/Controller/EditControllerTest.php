<?php

namespace NewsFeedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditControllerTest extends WebTestCase
{

    public function testSmoke()
    {
        $urls = ['/edit/list', '/edit/new'];
        $client = static::createClient();
        foreach ($urls as $url) {
            $client->request('GET', $url);
            $this->assertTrue($client->getResponse()->isRedirection());
        }
    }
}
