<?php
    if( ! ini_get('date.timezone') )
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    
    $configElasticPath = "http://localhost:9200/";
    $indexName = "dev-sabda-pustaka-2";
?>