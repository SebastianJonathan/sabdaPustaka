<?php
    $namaIndex = "pustaka8";
    
    $host = 'localhost';  // Your MySQL server hostname
    $username = 'root';  // Your MySQL username
    $password = '';  // Your MySQL password
    $database = 'sabda_pustaka';  // Your database name
    $tablename = "sabda_list_youtube_done"; // Your table name

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
    $url = 'http://localhost:9200/'.$namaIndex;  // Replace with your desired index and type
    $jsonUrl = 'mapping_es_nested_completion.json';

    // Fetch the JSON data
    $jsonData = file_get_contents($jsonUrl);

    $data = $jsonData;

    // Send the POST request to index the document
    $response = query($url, 'PUT', $data);
    print_r($response);


/*====**===*/

function splitKeyword($text){
    $hasil = array();
    if(strlen($text) >= 3){
        while (strlen($text) >= 3) {
            $hasil[] = $text;
            $text = substr($text,0,strlen($text) - 1);
        }
    }else{
        $hasil[] = $text;
    }
    return $hasil;
}



function compArr($divider, $word){
    $explode_arr = explode($divider, $word);
    $c3_arr = [];
    foreach($explode_arr as $exp){
        $split = splitKeyword($exp);
        $c3_arr = array_merge($c3_arr, $split);
    }
    $len_c = sizeof($c3_arr);
    $result = '[';
    for ($i = 0; $i < $len_c; $i++) {
        if($i != 0){
            $result = $result . ',';
        }
        $result = $result . '"'. $c3_arr[$i] .'"';
    }
    $result = $result . ']';
    return $result;
}

function multiv_comp($naras_arr){
    $naras_c_arr = [];
    foreach($naras_arr as $naras){
        $naras_pw = explode(" ",$naras);
        foreach($naras_pw as $naras_pw_c){
            $naras_c = splitKeyword($naras_pw_c);
            $naras_c_arr = array_merge($naras_c_arr, $naras_c);
        }
    }
    $len_c = sizeof($naras_c_arr);
    $result = '[';
    for ($i = 0; $i < $len_c; $i++) {
        if($i != 0){
            $result = $result . ',';
        }
        $result = $result . '"'. $naras_c_arr[$i] .'"';
    }
    $result = $result . ']';
    return $result;
}

function key_comp_a($kw_arr){
    // print_r($kw_arr);
    $kw_edited_arr = [];
    foreach($kw_arr as $kword){
        // $explode = explode(" ", $kword)
        $new_kw_sub = 
        '{"kunci": "'.$kword.'","kunci_completion": {"input": '.compArr(" ", $kword).',"weight": 1}}';
        array_push($kw_edited_arr, $new_kw_sub);
    }
    $result =  '[' . implode(", ", $kw_edited_arr) . ']';
    return $result;
}

function tanya_comp_a($tanya_arr){
    $result = "[";
    $len_tanya = sizeof($tanya_arr);
    for($i = 0; $i< $len_tanya; $i++){
        $new_tanya = '{ "pertanyaan": "'.$tanya_arr[$i].'"}';
        if ($i != ($len_tanya-1)){
            $new_tanya = $new_tanya . ',';
        }
        $result = $result . $new_tanya;
    }
    $result = $result . ']';
    return $result;
}



// Create a connection
$connection = new mysqli($host, $username, $password, $database);

// Check for connection errors
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
        // $narasumber_comp = compArr(" ", $narasumber);
        // "[" . implode(", ", explode(" ", $narasumber)) . "]";

        $url_static = $row['url_static'];
        $url_slideshare = $row['URL_Slideshare'];
        $url_yt = $row['url_youtube'];

        $short_desc = $row['short_desc'];
        $short_desc = str_replace('"', "'", $short_desc);
        $short_desc = implode("*", explode("\r\n", $short_desc));
        $short_desc = implode("*", explode("\n", $short_desc));
        // $short_desc = str_replace('*', '\n', $short_desc);

        $summary = $row['summary'];
        $summary = str_replace('"', "'", $summary);
        $summary = implode("*", explode("\r\n", $summary));
        $summary = implode("*", explode("\n", $summary));
        // $summary = str_replace('*', "\n", $summary);

        $keywords = $row['keywords'];
        $exp_keyword = explode(", ", $keywords);
        $jadi_keyword = multiv_comp($exp_keyword);

        $pertanyaan = $row['Pertanyaan'];
        $pertanyaan = str_replace('"', "'", $pertanyaan);
        $pertanyaan = implode("", explode("\r\n", $pertanyaan));
        $pertanyaan = implode("", explode("\n", $pertanyaan));
        // $exp_pertanyaan = explode(", ", $pertanyaan);
        // $jadi_pertanyaan = tanya_comp_a($exp_pertanyaan);
        
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


/*====**===*/

// Define the Elasticsearch index URL and document data
$url = 'http://localhost:9200/_bulk';  // Replace with your desired index and type

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
