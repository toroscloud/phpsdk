<?php

namespace Toros;

class Toros
{
    const URL = 'http://localhost/api/';
    public $msg;

    private $access_token;
    private $refresh_token;



    public function __construct($API_KEY, $API_SECRET)
    {
        if (!$this->connect($API_KEY, $API_SECRET)) {
            die("error connection");
        }
    }

    private function connect($API_KEY, $API_SECRET)
    {

        $this->http_user_agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : hash('sha512', rand() . date("YmdHis"));

        $curl = curl_init();

        $form = array(
            "grant_type"   => "client_credentials",
            "api_key"      => $API_KEY,
            "api_secret"   => $API_SECRET
        );

        $form = json_encode($form);

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL . "oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_USERAGENT => $this->http_user_agent,
            CURLOPT_POSTFIELDS => $form,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "cache-control: no-cache"
            ),
        ));



        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        }
        $response = json_decode($response);

        $this->access_token  = (isset($response->access_token)) ? $response->access_token : null;
        $this->refresh_token = (isset($response->refresh_token)) ? $response->refresh_token : null;

        if (!isset($response->success) || !$response->success)
            return false;

        return true;
    }



    public function newBucket($name)
    {

        $form = array("name" => $name);

        $form = json_encode($form);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL . "bucket",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_USERAGENT => $this->http_user_agent,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $form,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $this->access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        }

        return json_decode($response, true);
    }


    public function delBucket($name_bucket)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL . "bucket/" . $name_bucket,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_USERAGENT => $this->http_user_agent,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $this->access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        }

        return json_decode($response, true);
    }


    public function upload($name_bucket, $filePath, $file_destiny)
    {

        //Initiate cURL
        $ch = curl_init();

        //Set the URL
        curl_setopt($ch, CURLOPT_URL, self::URL . "bucket/" . $name_bucket);

        //Set the HTTP request to POST
        curl_setopt($ch, CURLOPT_POST, true);

        //Tell cURL to return the output as a string.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //If the function curl_file_create exists
        if (function_exists('curl_file_create')) {
            //Use the recommended way, creating a CURLFile object.
            $filePath = curl_file_create($filePath);
        } else {
            //Otherwise, do it the old way.
            //Get the canonicalized pathname of our file and prepend
            //the @ character.
            $filePath = '@' . realpath($filePath);
            //Turn off SAFE UPLOAD so that it accepts files
            //starting with an @
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        }

        //Setup our POST fields
        $postFields = array(
            'file'      => $filePath,
            'destiny'   => $file_destiny
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "authorization: Bearer " . $this->access_token,
            "cache-control: no-cache"
        ));



        $response = curl_exec($ch);


        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            return "cURL Error #:" . $err;
        }

        return json_decode($response, true);
    }


    public function delete($name_bucket, $file_destiny)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL . "bucket/" . $name_bucket . "/" . $file_destiny,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_USERAGENT => $this->http_user_agent,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $this->access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        }

        return json_decode($response, true);
    }


    public function list($name_bucket, $file_destiny)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL . "bucket/" . $name_bucket . "/" . $file_destiny,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_USERAGENT => $this->http_user_agent,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $this->access_token,
                "cache-control: no-cache"
            ),
        ));

        return $response = curl_exec($curl);
        

    }


    public function download($name_bucket, $file_destiny, $saveTo)
    {

        //Open file handler.
        $fp = fopen($saveTo, 'w+');
        //If $fp is FALSE, something went wrong.
        if ($fp === false) {
            throw new Exception('Could not open: ' . $saveTo);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL . "file/" . $name_bucket . "/" . $file_destiny,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_FILE => $fp,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $this->access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);


        $response = curl_exec($curl);
        return true;
        
    }
}
