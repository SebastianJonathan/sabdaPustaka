<?php
    function testConnect($configElasticPath, $indexName)
    {
        $header = array(
            'Content-Type: application/json'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $configElasticPath . $indexName);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($status == 200) {
            return true;
        } else {
            return false;
        }
    }
?>