<?php
include '../CONFIG/configES.php';
$url = $configElasticPath . $indexName . '/_search';
include 'query.php';

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

function getAllData($jsonFilter, $url){
    $field = $jsonFilter["fields"];
    if(empty($field)){
        $jsonData = [
            'data_result' => [],
            'unique_narasumber' => [],
            'unique_event' => [],
            'unique_tanggal' => [],
            'countEvent' => [],
            'countNarasumber' => [],
            'countTahun' => []
        ];
        echo json_encode(['result' => $jsonData]);
    }else{
        $narasumber = array();
        $event = array();
        $tanggal = array();
        $params2 = [
            'size' => 10000,
            'query' => [
                'match_all' => new stdClass(),
            ],
        ];
        $query2 = json_encode($params2);
        $response2 = query($url, $query2);
        if ($response2 === "E-CONN"){
            echo json_encode(['result' => $response2]);
        }else{
            $totalHits = 0;
            $countEvent = array();
            $countNarasumber = array();
            $countTahun = array();
            foreach($response2['hits']['hits'] as $datas){
                $totalHits += 1;
                $namaNarsum = $datas['_source']['narasumber'];
                $namaNarsum = str_replace(",S.","|S.",$namaNarsum);
                $namaNarsum = str_replace(", S.","| S.",$namaNarsum);
                $namaNarsum = str_replace(",B.","|B.",$namaNarsum);
                $namaNarsum = str_replace(", B.","| B.",$namaNarsum);
                $namaNarsum = str_replace(",M.","|M.",$namaNarsum);
                $namaNarsum = str_replace(", M.","| M.",$namaNarsum);
                $namaNarsum = str_replace(",Ph.","|Ph.",$namaNarsum);
                $namaNarsum = str_replace(", Ph.","| Ph.",$namaNarsum);
                $listNarasumber = explode(", ",$namaNarsum);
                foreach($listNarasumber as $namaNarasumber){
                    $namaNarasumber = str_replace("|",",",$namaNarasumber);
                    if (!isset($countNarasumber[$namaNarasumber])) {
                        $countNarasumber[$namaNarasumber] = 1;
                    }else{
                        $countNarasumber[$namaNarasumber] += 1;
                    }
                    if(!in_array($namaNarasumber, $narasumber)){
                        $narasumber[] = $namaNarasumber;
                    }
                }
                if (!isset($countEvent[$datas['_source']['event']])) {
                    $countEvent[$datas['_source']['event']] = 1;
                }else{
                    $countEvent[$datas['_source']['event']] += 1;
                }
                if(!in_array($datas['_source']['event'],$event)){
                    $event[] = $datas['_source']['event'];
                }
                if (!isset($countTahun[substr($datas['_source']['tanggal'],0,4)])) {
                    $countTahun[substr($datas['_source']['tanggal'],0,4)] = 1;
                }else{
                    $countTahun[substr($datas['_source']['tanggal'],0,4)] += 1;
                }
                if(!in_array(substr($datas['_source']['tanggal'],0,4),$tanggal)){
                    $tanggal[] = substr($datas['_source']['tanggal'],0,4);
                }
            }
            usort($tanggal, "dateComparison");
            $params = [
                'size' => $jsonFilter["size"],
                'query' => [
                    'match_all' => new stdClass(),
                ],        
                'sort' => [
                    'tanggal' => [
                        'order' => 'desc'
                    ]
                ],
                'from' => $jsonFilter["currPage"]
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
                    'youtube' => $source['url_youtube'],
                ];
            }
            $jsonData = [
                'data_result' => $result,
                'unique_narasumber' => $narasumber,
                'unique_event' => $event,
                'unique_tanggal' => $tanggal,
                'countEvent' => $countEvent,
                'countNarasumber' => $countNarasumber,
                'countTahun' => $countTahun,
                'total' => $totalHits
            ];
            echo json_encode(['result' => $jsonData]);
        }
    }
}

function search($jsonSearch, $url){
    $logFile = 'error.log';
    $field = $jsonSearch["fields"];
    if(empty($field)){
        $jsonData = [
            'data_result' => [],
            'unique_narasumber' => [],
            'unique_event' => [],
            'unique_tanggal' => [],
            'countEvent' => [],
            'countNarasumber' => [],
            'countTahun' => []
        ];
        echo json_encode(['result' => $jsonData]);
    }else{
        $result = array();
        $narasumber = array();
        $event = array();
        $tanggal = array();
        $params2 = [
            '_source' => ['judul', 'event', 'narasumber', 'url_youtube','tanggal'],
            'size' => 10000,
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'multi_match' => [
                                'query' => $jsonSearch["query"],
                                'fields' => $field,
                                'operator' => 'and',
                            ]
                        ]
                    ]
                ]
            ],
        ];
        $query2 = json_encode($params2);
        $response2 = query($url, $query2);
        if ($response2 === "E-CONN"){
            echo json_encode(['result' => $response2]);
        }else{
            $totalHits = 0;
            $countEvent = array();
            $countNarasumber = array();
            $countTahun = array();
            foreach($response2['hits']['hits'] as $datas){
                $totalHits += 1;
                $source = $datas['_source'];
                $namaNarsum = $datas['_source']['narasumber'];
                $namaNarsum = str_replace(",S.","|S.",$namaNarsum);
                $namaNarsum = str_replace(", S.","| S.",$namaNarsum);
                $namaNarsum = str_replace(",B.","|B.",$namaNarsum);
                $namaNarsum = str_replace(", B.","| B.",$namaNarsum);
                $namaNarsum = str_replace(",M.","|M.",$namaNarsum);
                $namaNarsum = str_replace(", M.","| M.",$namaNarsum);
                $namaNarsum = str_replace(",Ph.","|Ph.",$namaNarsum);
                $namaNarsum = str_replace(", Ph.","| Ph.",$namaNarsum);
                $listNarasumber = explode(", ",$namaNarsum);
                foreach($listNarasumber as $namaNarasumber){
                    $namaNarasumber = str_replace("|",",",$namaNarasumber);
                    if (!isset($countNarasumber[$namaNarasumber])) {
                        $countNarasumber[$namaNarasumber] = 1;
                    }else{
                        $countNarasumber[$namaNarasumber] += 1;
                    }
                    if(!in_array($namaNarasumber, $narasumber)){
                        $narasumber[] = $namaNarasumber;
                    }
                }
                if (!isset($countEvent[$datas['_source']['event']])) {
                    $countEvent[$datas['_source']['event']] = 1;
                }else{
                    $countEvent[$datas['_source']['event']] += 1;
                }
                if(!in_array($datas['_source']['event'],$event)){
                    $event[] = $datas['_source']['event'];
                }
                if (!isset($countTahun[substr($datas['_source']['tanggal'],0,4)])) {
                    $countTahun[substr($datas['_source']['tanggal'],0,4)] = 1;
                }else{
                    $countTahun[substr($datas['_source']['tanggal'],0,4)] += 1;
                }
                if(!in_array(substr($datas['_source']['tanggal'],0,4),$tanggal)){
                    $tanggal[] = substr($datas['_source']['tanggal'],0,4);
                }
            }
            usort($tanggal, "dateComparison");
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
                                ]
                            ]
                        ]
                    ]
                ],
                'from' => $jsonSearch["currPage"]
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
            }
            $jsonData = [
                'data_result' => $result,
                'unique_narasumber' => $narasumber,
                'unique_event' => $event,
                'unique_tanggal' => $tanggal,
                'countEvent' => $countEvent,
                'countNarasumber' => $countNarasumber,
                'countTahun' => $countTahun,
                'total' => $totalHits
            ];
            echo json_encode(['result' => $jsonData]);
        }
    }
}

function uniqueArray($arr) {
    $uniqueValues = array();
    foreach ($arr as $value) {
        if (!in_array($value, $uniqueValues)) {
            $uniqueValues[] = $value;
        }
    }
    return $uniqueValues;
}

function searchFilter($jsonSearch, $url){
    $logFile = 'error.log';
    $result = array();
    $field = $jsonSearch["fields"];
    if(empty($field)){
        $results = [
            'data' => [],
            'narasumber' => [],
            'event' => [],
            'tahun' => [],
            'countEvent' => [],
            'countNarasumber' => [],
            'countTahun' => [],
            'total' => 0
        ];
        echo json_encode(['result' => $results]);
    }else{
        if($jsonSearch["query"] === "Kosong"){
            $params2 = [
                '_source' => ['judul', 'event', 'narasumber', 'url_youtube', 'tanggal', 'deskripsi_pendek'],
                'size' => 10000,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'bool' => [
                                    'should' => []
                                ]
                            ]
                        ],
                    ],
                ],
            ];
        }else{
            $params2 = [
                '_source' => ['judul', 'event', 'narasumber', 'url_youtube', 'tanggal', 'deskripsi_pendek'],
                'size' => 10000,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'multi_match' => [
                                    'query' => $jsonSearch['query'],
                                    'fields' => $field,
                                    'operator' => 'and'
                                ]
                            ],
                            [
                                'bool' => [
                                    'should' => []
                                ]
                            ]
                        ],
                    ],
                ],
            ];
        }

        foreach($jsonSearch['narasumber'] as $narasumbers){
            $params2['query']['bool']['must'][] = [
                'match_phrase' => [
                    'narasumber' => $narasumbers
                ]
            ];
        }
        foreach($jsonSearch['event'] as $events){
            $params2['query']['bool']['must'][] = [
                'match_phrase' => [
                    'event' => $events
                ]
            ];
        }
        foreach($jsonSearch['tanggal'] as $tanggals){
            $params2['query']['bool']['must'][1]['bool']['should'][] = [
                'range' => [
                    'tanggal' => [
                        "gte" => $tanggals."-01-01",
                        "lte" => $tanggals."-12-31"
                    ]
                ]
            ];
        }
        
        $query2 = json_encode($params2);
        $response2 = query($url, $query2);
        $countTahun = array();
        $countNarasumber = array();
        $countEvent = array();
        $narasumberr = array();
        $event = array();
        $tahun = array();
        if ($response2 === "E-CONN"){
            echo json_encode(['result' => $response2]);
        }else{
            $totalHits = 0;
            foreach($response2['hits']['hits'] as $datas){
                $totalHits += 1;
                $source = $datas['_source'];
                if (!isset($countEvent[$source['event']])) {
                    $countEvent[$source['event']] = 1;
                }else{
                    $countEvent[$source['event']] += 1;
                }
                if(!in_array($source['event'],$event)){
                    $event[] = $source['event'];
                }
                if (!isset($countTahun[substr($source['tanggal'],0,4)])) {
                    $countTahun[substr($source['tanggal'],0,4)] = 1;
                }else{
                    $countTahun[substr($source['tanggal'],0,4)] += 1;
                }
                if(!in_array(substr($source['tanggal'],0,4),$tahun)){
                    $tahun[] = substr($source['tanggal'],0,4);
                }
                $namaNarsum = $source['narasumber'];
                $namaNarsum = str_replace(",S.","|S.",$namaNarsum);
                $namaNarsum = str_replace(", S.","| S.",$namaNarsum);
                $namaNarsum = str_replace(",B.","|B.",$namaNarsum);
                $namaNarsum = str_replace(", B.","| B.",$namaNarsum);
                $namaNarsum = str_replace(",M.","|M.",$namaNarsum);
                $namaNarsum = str_replace(", M.","| M.",$namaNarsum);
                $namaNarsum = str_replace(",Ph.","|Ph.",$namaNarsum);
                $namaNarsum = str_replace(", Ph.","| Ph.",$namaNarsum);
                $namaNarasumber = explode(", ",$namaNarsum);
                foreach($namaNarasumber as $narsum){
                    $narsum = str_replace("|",",",$narsum);
                    if (!isset($countNarasumber[$narsum])) {
                        $countNarasumber[$narsum] = 1;
                    }else{
                        $countNarasumber[$narsum] += 1;
                    }
                    if(!in_array($narsum,$narasumberr)){
                        $narasumberr[] = $narsum;
                    }
                }
            }
            usort($tahun, "dateComparison");
            
            if($jsonSearch["query"] === "Kosong"){
                $params = [
                    '_source' => ['judul', 'event', 'narasumber', 'url_youtube', 'tanggal', 'deskripsi_pendek'],
                    'size' => $jsonSearch["size"],
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'bool' => [
                                        'should' => []
                                    ]
                                ]
                            ],
                        ],
                    ],
                    'from' => $jsonSearch["currPage"]
                ];
            }else{
                $params = [
                    '_source' => ['judul', 'event', 'narasumber', 'url_youtube', 'tanggal', 'deskripsi_pendek'],
                    'size' => $jsonSearch["size"],
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'multi_match' => [
                                        'query' => $jsonSearch['query'],
                                        'fields' => $field,
                                        'operator' => 'and'
                                    ]
                                ],
                                [
                                    'bool' => [
                                        'should' => []
                                    ]
                                ]
                            ],
                        ],
                    ],
                    'from' => $jsonSearch["currPage"]
                ];
            }


            foreach($jsonSearch['narasumber'] as $narasumbers){
                $params['query']['bool']['must'][] = [
                    'match_phrase' => [
                        'narasumber' => $narasumbers
                    ]
                ];
            }
            foreach($jsonSearch['event'] as $events){
                $params['query']['bool']['must'][] = [
                    'match_phrase' => [
                        'event' => $events
                    ]
                ];
            }
            foreach($jsonSearch['tanggal'] as $tanggals){
                $params['query']['bool']['must'][1]['bool']['should'][] = [
                    'range' => [
                        'tanggal' => [
                            "gte" => $tanggals."-01-01",
                            "lte" => $tanggals."-12-31"
                        ]
                    ]
                ];
            }

            $query = json_encode($params);
            $response = query($url, $query);
            $allData = array();
            foreach($response['hits']['hits'] as $data){
                $source = $data['_source'];
                $allData[] = [
                    'event' => $source['event'],
                    'judul' => $source['judul'],
                    'narasumber' => $source['narasumber'],
                    'deskripsi_pendek' => $source['deskripsi_pendek'],
                    'id' => $data['_id'],
                    'youtube' => $source['url_youtube']

                ];
            }

            $results = [
                'data' => $allData,
                'narasumber' => $narasumberr,
                'event' => $event,
                'tahun' => $tahun,
                'countEvent' => $countEvent,
                'countNarasumber' => $countNarasumber,
                'countTahun' => $countTahun,
                'total' => $totalHits
            ];
            echo json_encode(['result' => $results]);
        }
    }
}

function extractUniqueSpeakers($hits){
    $uniqueNames = [];

    foreach ($hits as $hit) {
        $source = $hit['_source'];
        $names = "";
        $name = $source['narasumber'];
        $name = str_replace(",S.","|S.",$name);
        $name = str_replace(", S.","| S.",$name);
        $name = str_replace(",M.","|M.",$name);
        $name = str_replace(", M.","| M.",$name);
        $name = str_replace(",Ph.","|Ph.",$name);
        $name = str_replace(", Ph.","| Ph.",$name);
        $names = $name;
        $names = explode(", ", $names);

        foreach ($names as $participantName) {
            $cleanedName = trim($participantName);
            $cleanedName = str_replace("|",",",$cleanedName);
            if (!array_key_exists($cleanedName, $uniqueNames)) {
                $uniqueNames[$cleanedName] = 1 ;
            }else{
                $uniqueNames[$cleanedName]++;
            }
        }
    }
    return $uniqueNames;
}

function getAllEvent($url){
    // Query to retrieve all documents
    $params = [
        'size' => 10000, 
        'query' => [
            'match_all' => new \stdClass() // Empty query to retrieve all documents
        ],
        '_source' => ['event'] 
    ];

    $query = json_encode($params);
    $response = query($url, $query);
    if ($response === "E-CONN"){
        echo json_encode(['result' => $response]);
    }else{
        $hits = $response['hits']['hits'];
        $events = [];
        $eventCount = [];
        $eventList = [];

        foreach ($hits as $hit) {
            $source = $hit['_source'];

            if (isset($source['event'])) {
                if (!in_array(strtoupper($source['event']), $eventList)){
                    $events[] = $source['event'];
                    $eventCount[strtoupper($source['event'])] = 1; 
                    $eventList[] = strtoupper($source['event']);
                }else{
                    $eventCount[strtoupper($source['event'])]++;
                }
            }
        }

        $results = [];
        foreach($events as $ev){
            $count = $eventCount[strtoupper($ev)];
            $results[$ev] = $count;
        }


        echo json_encode(['result' => $results]);
    }
}

function getAllNarsum($url){
    // Query to retrieve all documents
    $params = [
        'size' => 1000, // Adjust the size to match the maximum number of documents to retrieve
        'query' => [
            'match_all' => new \stdClass() // Empty query to retrieve all documents
        ],
        '_source' => ['narasumber'] // Include only 'narasumber' and 'event' fields in the response
    ];

    $query = json_encode($params);
    $response = query($url, $query);
    if ($response === "E-CONN"){
        echo json_encode(['result' => $response]);
    }else{
        $hits = $response['hits']['hits'];
        $narasumbers = extractUniqueSpeakers($hits);
        // sort($narasumbers);
        echo json_encode(['result' => $narasumbers]);
    }
}


$jsonData = file_get_contents('php://input');
$jsonDataDecoded = json_decode($jsonData, true);
if($jsonDataDecoded["API"] == "getAll"){
    getAllData($jsonDataDecoded, $url);
} else if($jsonDataDecoded["API"] == "search"){
    search($jsonDataDecoded, $url);
} else if($jsonDataDecoded["API"] == "searchFilter"){
    searchFilter($jsonDataDecoded, $url);
} else if($jsonDataDecoded["API"] === "getAllEvent"){
    getAllEvent($url);
} else if($jsonDataDecoded["API"] == "getAllNarsum"){
    getAllNarsum($url);
} 
?>