<?php
if (strlen($_GET['query']) >= 3) {
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

    $url = 'http://localhost:9200/pustaka5/_search';

    $params = [
        'size' => 10,
        'query' => [
            'bool' => [
                'must' => [
                    [
                        'multi_match' => [
                            'query' => $_GET['query'],
                            'fields' => ['kata_kunci'],
                            'operator' => 'and'
                        ]
                    ]
                ]
            ]
        ]
    ];
    $query = json_encode($params);
    $response = query($url, $query);
    $hits = $response['hits']['hits'];

    $hasil = array();

    foreach ($hits as $hit) {
        $source = $hit['_source'];
        $hasil[] = [
            'event' => $source['narasumber'],
            'judul' => $source['judul'],
            'tanggal' => $source['tanggal']
        ];
    }
    echo json_encode(['hasil' => $hasil]);
}
?>
