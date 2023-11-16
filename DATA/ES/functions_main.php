<?php

// Langkah 1 - Membuat Index dengan mappingnya
function buat_index($ESPath, $indexName, $jsonUrl){
    $url = $ESPath.$indexName;

    // Fetch the JSON dat
    $data = file_get_contents($jsonUrl);

    // Send the POST request to index the document
    $response = query($url, 'PUT', $data);
    print_r($response);
}

// Langkah 2 - Menarik data SQL menjadi json yang disimpan pada text file
function sql_to_txt($host, $username, $password, $database, $tablename, $namaIndex){
    // Create SQL connection
    $connection = new mysqli($host, $username, $password, $database);
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    }

    // Query to fetch 5 rows from the "sssfffwww" table
    $query = "SELECT * FROM ".$tablename;
    $result = $connection->query($query);

    //Create folder bulk if not exist
    $folderName = "bulk";
    if (!file_exists($folderName)) {
        if (mkdir($folderName, 0777)) {
            echo "Folder ".$folderName." created successfully.";
        } else {
            echo "Unable to create the folder.".$folderName;
        }
    }

    // Check if any rows were returned
    $file_output = 'bulk\bulk1.txt';
    $file_counter = 1;
    $filename_arr = 'bulk\bulk1.txt';
    $i_counter = 0;
    $index_name = $namaIndex;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $metaline = '{ "index" : { "_index" : "'.$index_name.'", "_id":'.$i_counter.'}}';
            if ($i_counter%40 == 39){
                file_put_contents($file_output, "\n", FILE_APPEND);
                $file_counter += 1;
                $file_output = 'bulk\bulk'.$file_counter.'.txt';
                $filename_arr = $filename_arr .', '.$file_output;
                file_put_contents($file_output, $metaline);
            }else{
                if ($i_counter != 0 ){
                    file_put_contents($file_output, "\n". $metaline, FILE_APPEND);
                }else{
                    file_put_contents($file_output, $metaline);
                }
            }
            
            echo $metaline;
            echo "<br>";

            $i_counter += 1;

            $event = $row['event'];
            $event_comp = compArr(" ", $event);

            $judul = $row['judul'];
            $judul = str_replace('"', "'", $judul);
            $judul_comp = compArr(" ", $judul);

            $tanggal = $row['tanggal'];

            $narasumber = $row['narasumber'];
            $exp_naras = explode(", ", $narasumber);
            $narasumber_comp = multiv_comp($exp_naras);

            $url_static = $row['url_static'];
            $url_slideshare = $row['url_slideshare'];
            $url_yt = $row['url_youtube'];

            $short_desc = $row['short_desc'];
            $short_desc = str_replace('"', "'", $short_desc);
            $short_desc = implode("*", explode("\r\n", $short_desc));
            $short_desc = implode("*", explode("\n", $short_desc));

            $summary = $row['summary'];
            $summary = str_replace('"', "'", $summary);
            $summary = implode("*", explode("\r\n", $summary));
            $summary = implode("*", explode("\n", $summary));

            $keywords = $row['keywords'];
            $exp_keyword = explode(", ", $keywords);
            $jadi_keyword = multiv_comp($exp_keyword);

            $pertanyaan = $row['pertanyaan'];
            $pertanyaan = str_replace('"', "'", $pertanyaan);
            $pertanyaan = implode("", explode("\r\n", $pertanyaan));
            $pertanyaan = implode("", explode("\n", $pertanyaan));
            
            $dataline = '{"event": "'.$event.'","event_completion": {"input": '.$event_comp.',"weight": 1},"judul": "'.$judul.'","judul_completion": {"input": '.$judul_comp.',"weight": 1},"tanggal": "'.$tanggal.'","narasumber": "'.$narasumber.'","narasumber_completion": {"input": '.$narasumber_comp.',"weight": 1},"url_static": "'.$url_static.'","url_slideshare": "'.$url_slideshare.'","url_youtube": "'.$url_yt.'","deskripsi_pendek": "'.$short_desc.'","ringkasan": "'.$summary.'","kata_kunci": "'.$keywords.'","kata_kunci_completion": {"input": '.$jadi_keyword.',"weight": 1},"list_pertanyaan": "'.$pertanyaan.'"}';

            file_put_contents($file_output, "\n".$dataline, FILE_APPEND);

        }
        file_put_contents($file_output, "\n", FILE_APPEND);
        echo "Successfully write ".$filename_arr;
    } else {
        echo "No rows found.";
    }

    // Close the connection when done
    $connection->close();
}

// Langkah 3 - Upload data dari text file ke ES secara bulk
function txt_to_ES($ESPath, $bulkDir){
    // Define the Elasticsearch index URL and document data
    // $url = 'http://charis.sabda.ylsa:9200/_bulk';  // Replace with your desired index and type
    $url = $ESPath.'_bulk';


    $files_bulk = [];
    $ffs = scandir($bulkDir);
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            array_push($files_bulk, $bulkDir."/".$ff);
            if(is_dir($bulkDir.'/'.$ff)) listFolderFiles($bulkDir.'/'.$ff);
        }
    }

    foreach($files_bulk as $file){
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
}

?>