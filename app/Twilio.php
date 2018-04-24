<?php
namespace App;

class Twilio
{
    protected $config;
    protected $client;

    function __construct($config)
    {
        $this->config = $config;
        $this->client = new \Twilio\Rest\Client(
            $config['twilio.sid'],
            $config['twilio.token']
        );
    }

    public function sendSms($to, $message)
    {
        $result = $this->client->messages->create(
            $to, // Text this number
            array(
                'from' => $this->config['twilio.from'], // From a valid Twilio number
                'body' => $message
            )
        );
        return $result;
    }
    
}