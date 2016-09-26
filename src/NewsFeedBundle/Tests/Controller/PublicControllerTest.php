<?php

namespace NewsFeedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PublicControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testNews()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/news');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    
    public function testView()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/view/1');
        
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testPdf()
    {
        $client = static::createClient();
        $client->request('GET', '/pdf/1');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

}
