<?php
    function query($url, $param) {
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
    function dateComparison($date1, $date2) {
        $datetime1 = strtotime($date1);
        $datetime2 = strtotime($date2);
        if ($datetime1 < $datetime2) {
            return -1;
        } elseif ($datetime1 == $datetime2) {
            return 0;
        } else {
            return 1;
        }
    }
    function filterMulti($jsonFilter){
        $logFile = 'error.log';
        $result = array();
        $url = 'http://localhost:9200/pustaka6/_search';
        $params = [
            'size' => $jsonFilter["size"],
            'query' => [
                'bool' => [
                    'must' => []
                ]
            ],
        ];
        foreach ($jsonFilter["narasumber"] as $narasumber) {
            $params['query']['bool']['must'][] = [
                'multi_match' => [
                    'query' => $narasumber,
                    'fields' => ['narasumber'],
                    'operator' => 'and'
                ],
            ];
        }
        foreach ($jsonFilter["event"] as $event) {
            $params['query']['bool']['must'][] = [
                'multi_match' => [
                    'query' => $event,
                    'fields' => ['event'],
                    'operator' => 'and'
                ],
            ];
        }
        $query = json_encode($params);
        error_log($query,3,$logFile);
        $response = query($url, $query);
        $hits = $response['hits']['hits'];
        foreach ($hits as $hit) {
            $source = $hit['_source'];
            $result[] = [
                'event' => $source['event'],
                'judul' => $source['judul'],
                'narasumber' => $source['narasumber'],
                'deskripsi_pendek' => $source['deskripsi_pendek'],
                'id' => $hit['_id']
            ];
        }
        echo json_encode(['result' => $result]);
    }
    function search($jsonSearch){
        $logFile = 'error.log';
        $field = $jsonSearch["fields"];
        $result = array();
        $narasumber = array();
        $event = array();
        $tanggal = array();
        $url = 'http://localhost:9200/pustaka6/_search';
        $params = [
            'size' => $jsonSearch["size"],
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'multi_match' => [
                                'query' => $jsonSearch["query"],
                                'fields' => $field,
                                'operator' => 'and',
                                'fuzziness' => 'AUTO'
                            ]
                        ]
                    ]
                ]
            ],
        ];
        $query = json_encode($params);
        $response = query($url, $query);
        $hits = $response['hits']['hits'];
        foreach ($hits as $hit) {
            $source = $hit['_source'];
            $result[] = [
                'event' => $source['event'],
                'judul' => $source['judul'],
                'narasumber' => $source['narasumber'],
                'deskripsi_pendek' => $source['deskripsi_pendek'],
                'id' => $hit['_id'],
                'youtube' => $source['url_youtube']
            ];
            $listNarasumber = explode(", ",$source['narasumber']);
            foreach($listNarasumber as $namaNarasumber){
                if(!in_array($namaNarasumber, $narasumber)){
                    $narasumber[] = $namaNarasumber;
                }
            }
            if(!in_array($source['event'],$event)){
                $event[] = $source['event'];
            }
            if(!in_array($source['tanggal'],$tanggal)){
                $tanggal[] = $source['tanggal'];
            }
        }
        usort($tanggal, "dateComparison");
        $jsonData = [
            'data_result' => $result,
            'unique_narasumber' => $narasumber,
            'unique_event' => $event,
            'unique_tanggal' => $tanggal
        ];
        echo json_encode(['result' => $jsonData]);
    }
    function searchFilter($jsonSearch){
        $logFile = 'error.log';
        $result = array();
        $field = $jsonSearch["fields"];
        $url = 'http://localhost:9200/pustaka6/_search';
        $params = [
            'size' => $jsonSearch["size"],
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'multi_match' => [
                                'query' => $jsonSearch["query"],
                                'fields' => $field,
                                'operator' => 'and',
                                'fuzziness' => 'AUTO'
                            ]
                        ],
                    ],
                ],
            ],
        ];
        $query = json_encode($params);
        error_log($query,3,$logFile);
        $response = query($url, $query);
        $hits = $response['hits']['hits'];
        foreach ($hits as $hit) {
            $source = $hit['_source'];
            if(!empty($jsonSearch["event"])){
                if(!empty($jsonSearch["narasumber"])){
                    if(!empty($jsonSearch["tanggal"])){
                        $listNarasumber = explode(", ",$source['narasumber']);
                        foreach($listNarasumber as $namaNarasumber){
                            if(in_array($source["event"], $jsonSearch["event"]) and in_array($namaNarasumber, $jsonSearch["narasumber"]) and in_array($source["tanggal"],$jsonSearch["tanggal"])){
                                $result[] = [
                                    'event' => $source['event'],
                                    'judul' => $source['judul'],
                                    'narasumber' => $source['narasumber'],
                                    'deskripsi_pendek' => $source['deskripsi_pendek'],
                                    'id' => $hit['_id'],
                                    'youtube' => $source['url_youtube']
                                ];
                            }
                        }
                    }else {
                        $listNarasumber = explode(", ",$source['narasumber']);
                        foreach($listNarasumber as $namaNarasumber){
                            if(in_array($source["event"], $jsonSearch["event"]) and in_array($namaNarasumber, $jsonSearch["narasumber"])){
                                $result[] = [
                                    'event' => $source['event'],
                                    'judul' => $source['judul'],
                                    'narasumber' => $source['narasumber'],
                                    'deskripsi_pendek' => $source['deskripsi_pendek'],
                                    'id' => $hit['_id'],
                                    'youtube' => $source['url_youtube']
                                ];
                            }
                        }
                    }
                }
                else{
                    if(!empty($jsonSearch["tanggal"])){
                        if(in_array($source["event"], $jsonSearch["event"]) and in_array($source["tanggal"], $jsonSearch["tanggal"])){
                            $result[] = [
                                'event' => $source['event'],
                                'judul' => $source['judul'],
                                'narasumber' => $source['narasumber'],
                                'deskripsi_pendek' => $source['deskripsi_pendek'],
                                'id' => $hit['_id'],
                                'youtube' => $source['url_youtube']
                            ];
                        }
                    }else {
                        if(in_array($source["event"], $jsonSearch["event"])){
                            $result[] = [
                                'event' => $source['event'],
                                'judul' => $source['judul'],
                                'narasumber' => $source['narasumber'],
                                'deskripsi_pendek' => $source['deskripsi_pendek'],
                                'id' => $hit['_id'],
                                'youtube' => $source['url_youtube']
                            ];
                        }
                    }
                }
            }else if(!empty($jsonSearch["tanggal"])){
                if(!empty($jsonSearch["narasumber"])){
                    $listNarasumber = explode(", ",$source['narasumber']);
                    foreach($listNarasumber as $namaNarasumber){
                        if(in_array($namaNarasumber, $jsonSearch["narasumber"]) and in_array($source["tanggal"],$jsonSearch["tanggal"])){
                            $result[] = [
                                'event' => $source['event'],
                                'judul' => $source['judul'],
                                'narasumber' => $source['narasumber'],
                                'deskripsi_pendek' => $source['deskripsi_pendek'],
                                'id' => $hit['_id'],
                                'youtube' => $source['url_youtube']
                            ];
                        }
                    }
                } else{
                    if(in_array($source["tanggal"],$jsonSearch["tanggal"])){
                        $result[] = [
                            'event' => $source['event'],
                            'judul' => $source['judul'],
                            'narasumber' => $source['narasumber'],
                            'deskripsi_pendek' => $source['deskripsi_pendek'],
                            'id' => $hit['_id'],
                            'youtube' => $source['url_youtube']
                        ];
                    }
                }
            }
            else {
                if(!empty($jsonSearch["narasumber"])){
                    $listNarasumber = explode(", ",$source['narasumber']);
                    foreach($listNarasumber as $narasumber){
                        if(in_array($narasumber, $jsonSearch["narasumber"])){
                            $result[] = [
                                'event' => $source['event'],
                                'judul' => $source['judul'],
                                'narasumber' => $source['narasumber'],
                                'deskripsi_pendek' => $source['deskripsi_pendek'],
                                'id' => $hit['_id'],
                                'youtube' => $source['url_youtube']
                            ];
                        }
                    }
                }else{
                    $result[] = [
                        'event' => $source['event'],
                        'judul' => $source['judul'],
                        'narasumber' => $source['narasumber'],
                        'deskripsi_pendek' => $source['deskripsi_pendek'],
                        'id' => $hit['_id'],
                        'youtube' => $source['url_youtube']
                    ];
                }
            }
        }
        echo json_encode(['result' => $result]);
    }
    $jsonData = file_get_contents('php://input');
    $jsonDataDecoded = json_decode($jsonData, true);
    if($jsonDataDecoded["API"] == "filter"){
        filterMulti($jsonDataDecoded);
    } else if($jsonDataDecoded["API"] == "search"){
        search($jsonDataDecoded);
    } else if($jsonDataDecoded["API"] == "searchFilter"){
        searchFilter($jsonDataDecoded);
    }
?>