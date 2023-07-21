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
        $result = json_decode($response, true);

        return $result;
    }

    function getAll($querys){
        $url = 'http://localhost:9200/pustaka6/_search';
        $params = [
            'query' => [
                'match_all' => (object) [],
            ],
            'size' => 1000
        ];
        $query = json_encode($params);
        $response = query($url, $query);
        $hits = $response['hits']['hits'];
        if($querys == "narasumber"){
            $allNarasumber = [];

            foreach ($hits as $hit) {
                $listNarasumber = explode(",",$hit['_source']['narasumber']);
                foreach ($listNarasumber as $namaNarasumber){
                    if(!in_array($namaNarasumber,$allNarasumber)){
                        $allNarasumber[] = $namaNarasumber;
                    }
                }
            }
            echo json_encode(['result' => $allNarasumber]);
        }else if($querys == "event"){
            $allEvent = [];

            foreach ($hits as $hit) {
                if(!in_array($hit['_source']['event'],$allEvent)){
                    $allEvent[] = $hit['_source']['event'];
                }
            }
            echo json_encode(['result' => $allEvent]);
        }
    }
    $querys = $_GET['query'];
    getAll($querys);
?>