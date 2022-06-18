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
            return 'Disputed';
        }
        else
        {
            return 'Disput';
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

$twilio = new Twilio('ACfc5a0354828c3c703a2c9d06365d2d73', '8551726162fb53956c659e773d42e7cd');
$all_calls = json_decode($twilio->get_calls(), true);
// $all_calls foreach loop in table

$all_call = '';

$i = 1;

foreach ($all_calls['calls'] as $call){

    if($twilio->check_disputed($call['sid']) == 'Disputed')
    {
        $result = $twilio->get_disputed_value($call['sid']);
    }
    else
    {
        $result = '<form action="store.php" method="POST">'.
                    '<div class="mb-3">'.
                        '<input type="hidden" name="caller_sid" value="'. $call['sid'] .'">'.
                         '<label for="exampleInputEmail1" class="form-label">Write down the reason: </label>'.
                           '<textarea require name="reason" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>'.
                    '</div>'.
                    '<div class="modal-footer">'.
                        '<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>'.
                        '<button type="submit" class="btn btn-primary">Dispute</button>'.
                    '</div>'.
                '</form>';
    }

    $all_call .= '<tr>'.
        '<td>' . $i++ . '</td>'.
        '<td>' . $call["sid"] . '</td>'.
        '<td>'.$call['from_formatted'].'</td>'.
        '<td>'.$call['to_formatted'].'</td>'.
        '<td>'.$call['duration'].'</td>'.
        '<td>'.$call['start_time'].'</td>'.
        '<td>'.$call['end_time'].'</td>'.
        '<td>'.$call['status'].'</td>'.
        '<td>'.
            '<audio controls>'.
                '<source src="'.$twilio->get_recording($call['sid']).'" type="audio/mpeg">'.
                'Your browser does not support the audio element.'.
            '</audio>'.
        '</td>'.
        '<td>'.
            '<button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#'. $call['sid'] .'">'.
                '<span class="badge badge-pill badge-danger">'. $twilio->check_disputed($call['sid']) .'</span>'.
            '</button>'.

            '<div class="modal fade" id="'. $call['sid'] .'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'.
                '<div class="modal-dialog" role="document">'.
                    '<div class="modal-content">'.
                        '<div class="modal-header">'.
                            '<h5 class="modal-title" id="exampleModalLabel">'. $call['sid'] .'</h5>'.
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'.
                                '<span aria-hidden="true">&times;</span>'.
                            '</button>'.
                        '</div>'.
                        '<div class="modal-body">'.
                            '<div>'. $result .'</div>'.
                        '</div>'.
                        
                    '</div>'.
                '</div>'.
        '</td>'
        ;
}