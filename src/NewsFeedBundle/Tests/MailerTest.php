<?php

namespace NewsFeedBundle\Tests;

use NewsFeedBundle\Mailer;

class MailerTest extends \PHPUnit_Framework_TestCase
{

    public function testFakeSend()
    {
        $appDir = realpath(__DIR__."/../../../app");
        $mailer = new Mailer([
            'type' => 'fakesendmail',
            'path' => "$appDir/fakesendmail.sh  $appDir/logs"
        ]);

        $message = md5(rand());

        $mailer->setFrom('test@example.com');
        $mailer->addAddress('test@example.com');
        $mailer->setSubject('Here is the subject');
        $mailer->setBody($message);
        $mailer->send();

        $logFile = "$appDir/logs/fakesendmail.log";
        $line    = trim(`tail -n 1 $logFile`);

        $this->assertEquals($message,  $line);
    }
}
