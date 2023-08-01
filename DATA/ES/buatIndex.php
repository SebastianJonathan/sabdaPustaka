<?php
    function query($url, $method, $param = null)
    {
        $header = array(
            'Content-Type: application/json'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        if ($param) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);

        return $result;
    }

    // Define the Elasticsearch index URL and document data
    $url = 'http://localhost:9200/cobaw';  // Replace with your desired index and type

    $jsonUrl = 'mapping_es_nested_completion.json';

// Fetch the JSON data
$jsonData = file_get_contents($jsonUrl);

    $data = $jsonData;

    // Send the POST request to index the document
    $response = query($url, 'PUT', $data);
    print_r($response)
    // Check if the response indicates a successful indexing
    // if (isset($response['_index']) && isset($response['_id'])) {
    //     echo "Document indexed successfully." . "<br>";
    //     echo "Index: " . $response['_index'] . "<br>";
    //     echo "ID: " . $response['_id'] . "<br>";
    // } else {
    //     echo "Failed to index the document.";
    // }
?>
