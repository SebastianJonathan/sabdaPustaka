<?php
    if(strlen($_GET['query']) >= 3){
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

        $url = 'http://localhost:9200/pustaka6/_search';

        $params = [
            'size' => 10,
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'multi_match' => [
                                'query' => $_GET['query'],
                                'fields' => ['kata_kunci_completion.input'],
                                'operator' => 'and'
                            ]
                        ]
                    ]
                ]
            ],
            'highlight' => [
                'pre_tags' => ['<strong>'],
                'post_tags' => ['</strong>'],
                'fields' => ['kata_kunci_completion.input' => new \stdClass()]
            ]
        ];
        $query = json_encode($params);
        $response = query($url, $query);
        $hits = $response['hits']['hits'];

        $hasil = array();

        $queryy = $_GET['query'];
        foreach ($hits as $hit) {
            $source = $hit['_source'];
            $keyword = $source['kata_kunci'];
            $listKeyword = explode(", ",$keyword);
            foreach($listKeyword as $namaKeyword){
                if(strtolower($namaKeyword) == strtolower($queryy)){
                    $hasil[] = [
                        'event' => $source['narasumber'],
                        'judul' => $source['judul'],
                        'deskripsi_pendek' => $source['deskripsi_pendek'],
                        'id' => $hit['_id']
                    ];
                    break;
                }
            }
        }
        echo json_encode(['hasil' => $hasil]);
    }
?>