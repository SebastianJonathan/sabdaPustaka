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
    $url = 'http://charis.sabda.ylsa:9200/_bulk';  // Replace with your desired index and type

    function listFolderFiles($dir){
        $files = [];
        $ffs = scandir($dir);
        foreach($ffs as $ff){
            if($ff != '.' && $ff != '..'){
                array_push($files, "bulk/".$ff);
                // echo $ff."<br>";
                if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            }
        }
        return $files;
    }
    $files_bulk = listFolderFiles('bulk');

    foreach($files_bulk as $file){
        // $file = 'bulk2.txt';
        $data = file_get_contents($file);
    
        // Send the POST request to index the document
        $response = query($url, 'POST', $data);
        // print_r($response);
        if ($response['errors']==""){
            echo "Successful for ".$file."<br>";
        }else{
            $i_inspect = 0;
            foreach($response['items'] as $row){
                if (($row['index']['status'] != '200') && ($row['index']['status'] != 201)){
                    print("ERROR Index ".$i_inspect."<br>");
                    print_r($row['index']['error']);
                    print("<br>---<br>");
                }
                $i_inspect += 1;
            }
        }
    }
?>
