<?php
    function query($url, $param)
    {
        $header = array(
            'Content-Type: application/json'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        if (!$response){
            if (testConnect($url)){
                return "E-DATA";
            }else{
                return "E-CONN";
            }
        }
        $result = json_decode($response, true);

        return $result;
    }

    function testConnect($url)
    {
        $header = array(
            'Content-Type: application/json'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($status == 200) {
            return "connection ok";
        } else {
            return false;
        }
    }
?>