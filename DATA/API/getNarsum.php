<?php
include '../CONFIG/configES.php';
$url = $configElasticPath . $indexName . '/_search';
include 'query.php';

// Get the 'event' query parameter from the URL
$narsumParam = isset($_GET['query']) ? $_GET['query'] : '';

if (empty($narsumParam)) {
    // If the 'event' parameter is empty, return an empty array
    echo json_encode(['hasil' => []]);
    exit();
}

$params = [
    'size' => 1000,
    'query' => [
        'bool' => [
            'must' => [
                [
                    'multi_match' => [
                        'query' => $narsumParam,
                        'fields' => ['narasumber_completion.input'],
                        'operator' => 'and',
                    ]
                ]
            ]
        ]
    ],
    '_source' => ['event','narasumber', 'judul', 'deskripsi_pendek', 'url_youtube', 'ringkasan'],
];
$query = json_encode($params);
$response = query($url, $query);
if ($response === "E-CONN"){
    echo json_encode(['hasil' => $response]);
}else{

    $hits = $response['hits']['hits'];
    $hasil = [];

    foreach ($hits as $hit) {
        $source = $hit['_source'];
        $youtubeUrl = isset($source['url_youtube']) ? $source['url_youtube'] : '';

        $hasil[] = [
            'event' => $source['event'],
            'narasumber' => $source['narasumber'],
            'judul' => $source['judul'],
            'deskripsi_pendek' => $source['deskripsi_pendek'],
            'id' => $hit['_id'],
            'youtube' => $youtubeUrl,
            'ringkasan' => $source['ringkasan']
        ];
    }

    // Echo the search results
    echo json_encode(['hasil' => $hasil]);
}
?>
