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


    $url = 'http://localhost:9200/pustaka6/_search';

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
    $hits = $response['hits']['hits'];

    $hasil = array();

    foreach ($hits as $hit) {
        $source = $hit['_source'];
        $youtubeUrl = isset($source['url_youtube']) ? $source['url_youtube'] : '';
        $hasil[] = [
            'narasumber' => $source['narasumber'],
            'judul' => $source['judul'],
            'deskripsi_pendek' => $source['deskripsi_pendek'],
            'id' => $hit['_id'],
            'youtube' => $youtubeUrl
        ];
    }
    echo json_encode(['hasil' => $hasil]);
?>