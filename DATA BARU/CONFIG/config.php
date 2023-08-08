<?php

    if( ! ini_get('date.timezone') )
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    //setup juga di configES.php
    $configElasticPath = "http://charis.sabda.ylsa:9200/";
    $indexName = "dev-sabda-pustaka-2";
    $configPath = "http://dev.sabda.its/sabdapustaka/";
?>
