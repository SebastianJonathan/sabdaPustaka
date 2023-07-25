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

// Set the Elasticsearch index name and endpoint URL
$index = 'pustaka6';
$url = 'http://localhost:9200/' . $index . '/_search';

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
];
$query = json_encode($params);
$response = query($url, $query);
$hits = $response['hits']['hits'];
$hasil = [];

foreach ($hits as $hit) {
    $source = $hit['_source'];
    $youtubeUrl = isset($source['url_youtube']) ? $source['url_youtube'] : '';

    $hasil[] = [
        'narasumber' => $source['narasumber'],
        'judul' => $source['judul'],
        'deskripsi_pendek' => $source['deskripsi_pendek'],
        'id' => $hit['_id'],
        'youtube' => $youtubeUrl,
    ];
}

// Echo the search results
echo json_encode(['hasil' => $hasil]);
?>