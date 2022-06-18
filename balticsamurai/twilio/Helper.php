<?php

require 'db.php';
include('DisputeController.php');

class Twilio {

    /**
     * @var string
     */
    public $account_sid;
    public $auth_token;

    /**
     * @var string
     */
    public function __construct($account_sid, $auth_token) 
    {
        $this->account_sid = $account_sid;
        $this->auth_token = $auth_token;
    }

    /**
     * @output get all the call logs
     * @return array
     */

    public function get_calls() 
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.twilio.com/2010-04-01/Accounts/'. $this->account_sid .'/Calls.json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authorization: Basic ".base64_encode($this->account_sid . ":" . $this->auth_token)
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * get_recording
     */
    public function get_recording($caller_sid)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.twilio.com/2010-04-01/Accounts/'. $this->account_sid .'/Calls/'. $caller_sid .'/Recordings.json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authorization: Basic ".base64_encode($this->account_sid . ":" . $this->auth_token)
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $recordings = json_decode($response);

        foreach ($recordings->recordings as $recording) {
            return $recording->media_url;
        }
    }

    /**
     * Check Disputed in mysql
     */

    public function check_disputed($caller_sid)
    {
        $dispute = new DisputeController;
        $result = $dispute->get_disputed($caller_sid);
        if($result)
        {
            return 'true';
        }
        else
        {
            return 'false';
        }
    }

    /**
     * Disputed value
     */

    public function get_disputed_value($caller_sid)
    {
        $dispute = new DisputeController;
        $result = $dispute->get_disputed_value($caller_sid);
        if($result)
        {
            return $result;
        }
        else
        {
            return false;
        }
    }
}

$twilio = new Twilio('ACfc5a0354828c3c703a2c9d06365d2d73', 'cc6d90f86ba1d37c79cd7a5cceeaadbb');
$all_calls = json_decode($twilio->get_calls(), true);