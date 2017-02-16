<?php

//API Settings
define('LOCAL_URL', 'http://localhost/r25/');
define('BASE_URL', LOCAL_URL);

define('API_URL', BASE_URL . 'phpMyRest/');
define('API_KEY', 'uLMXrY4RWuVnWqf8LgkG4ptYXHt5vrEV');
define('API_DEBUG', TRUE);

if (!function_exists('suQuery')) {

    //Send SQL to API
    function suQuery($sql, $do = 'select') {

        ///===
        $url = API_URL;
        $fields = array(
            'do' => $do,
            'sql' => $sql,
            'api_key' => API_KEY,
            'debug' => API_DEBUG,
        );

        //url-ify the data for the POST
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        //execute post
        $request = curl_exec($ch);

        //close connection
        curl_close($ch);

        //Decode json response to php array
        $response = json_decode($request, true);
        //Return response
        return $response;
    }

}

$sql = "SELECT * FROM sulata_settings";
$a = suQuery($sql);
echo "<pre>";
print_r($a);
