<?php

namespace NewsFeedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PublicControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/List');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/view');
    }

    public function testPdf()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/pdf');
    }

    public function testNews()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news');
    }

}
