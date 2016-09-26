<?php

namespace NewsFeedBundle;

class Mailer
{
    private $phpmailer = null;

    public function __construct($params)
    {
        switch($params['type']) {
            case 'smtp':
                // FIXME...
                break;
            default:
                $this->phpmailer = new \PHPMailer;
                $this->phpmailer->isSendmail();
                $this->phpmailer->Sendmail = $params['path'];

        }

    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->phpmailer, $name), $arguments);
    }

    public function setSubject($subject)
    {
        $this->phpmailer->Subject = $subject;
    }
    
    public function setBody($body)
    {
        $this->phpmailer->Body = $body;
    }

    public function send()
    {
        if ( $this->phpmailer->send() ) {
            return true;
        } else {
            throw new \Exception($this->phpmailer->ErrorInfo);
        }
    }

}
