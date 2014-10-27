<?php
/**
 * Created by PhpStorm.
 * User: svenanders
 * Date: 27.10.14
 * Time: 11.58
 */

/*
// //USAGE
$mail = new SendMailGun();
$mail->setFrom("anders@robbestad.com");
$mail->setTo("anders@robbestad.com");
$mail->setAPIKey($config["mailgun_api_key"]);
$mail->setMessage("I'm sending mail from Heroku");
$mail->setSubject("Message from Heroku");
$mail->send();
*/


use Mailgun\Mailgun;

class SendMailGun
{
    protected $from, $to, $subject, $message, $key;

    public function __construct()
    {
    }

    public function setFrom($from){
        $this->from = $from;
    }

    public function setTo($to){
        $this->to = $to;
    }

    public function setSubject($subject){
        $this->subject = $subject;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function setAPIKey($key){
        $this->key = $key;
    }

    public function send()
    {
        # Instantiate the client.
        $client = new Mailgun($this->key);

        $subject = "test";
        $message = "testing";

        $result = $client->sendMessage('svenardo.com', array(
            'from' => $this->from,
            'to' => $this->to ,
            'subject' => $this->subject ,
            'text' => $this->message,
        ));
    return $result;
    }
}