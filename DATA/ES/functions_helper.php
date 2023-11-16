<?php

function query($url, $method, $param = null){
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




?>