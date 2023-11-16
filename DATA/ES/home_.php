<?php

include 'functions_helper.php';
include 'functions_main.php';

// ES Config
$configElasticPath = "http://charis.sabda.ylsa:9200/";
$indexName = "dev-sabda-pustaka-2";

// SQL Config
$host = 'localhost';  // Your MySQL server hostname
$username = 'sabda';  // Your MySQL username
$password = 'password';  // Your MySQL password
$database = 'dev_data';  // Your database name
$tablename = "sabda_list_youtube_done"; // Your table name

// File Config
$jsonUrl = 'mapping_es_nested_completion.json'; // Json containing the mapping
$bulkDir = 'bulk'; // Bulk text file directory


////////////////////////////////////////////////////////////////////////////////////////

$is_buat_index = true;
$is_sql_to_txt = true;
$is_txt_to_es = true;

if ($is_buat_index){
    buat_index($configElasticPath, $indexName, $jsonUrl);
}
if ($is_sql_to_txt){
    sql_to_txt($host, $username, $password, $database, $tablename, $indexName);
}
if ($is_txt_to_es){
    txt_to_ES($configElasticPath, $bulkDir);
}





?>
