<?php
    include '../CONFIG/config.php';
    $url = $configElasticPath . $index . '/_search';
    include 'query.php';

    function getAll($querys){
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