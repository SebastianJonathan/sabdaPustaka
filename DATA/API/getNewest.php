<?php
    include '../CONFIG/configES.php';
    $url = $configElasticPath . $indexName . '/_search';
    include 'query.php';
    $params = [
        'size' => '8',
        'query' => [
            'bool' => [
                'filter' => [
                    'range' => [
                        'tanggal' => [
                            "gte" => "2023-01-01",
                            "lt" => "2024-01-01"
                        ]
                    ]
                ]
            ]
        ],
        'sort' => [
            'tanggal' => [
                'order' => 'desc'
            ]
        ]
    ];
    $query = json_encode($params);
    $response = query($url, $query);

    if ($response === "E-CONN"){
        echo json_encode(['hasil' => $response]);
    }else{

        $hits = $response['hits']['hits'];

        $hasil = array();

        foreach ($hits as $hit) {
            $source = $hit['_source'];
            $youtubeUrl = isset($source['url_youtube']) ? $source['url_youtube'] : '';
            $hasil[] = [
                'event' => $source['event'],
                'narasumber' => $source['narasumber'],
                'judul' => $source['judul'],
                'deskripsi_pendek' => $source['deskripsi_pendek'],
                'id' => $hit['_id'],
                'youtube' => $youtubeUrl
            ];
        }
        echo json_encode(['hasil' => $hasil]);
    }
?>
