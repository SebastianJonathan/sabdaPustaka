<?php
include 'DATA/API/configES.php';
if (strlen($_GET['query']) >= 3) {
    $url = $configElasticPath . $indexName . '/_search';
    include 'query.php';

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
