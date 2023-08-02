<?php
include 'configES.php';
$url = '/_search';
function query($url, $method, $param)
{
    $header = array(
        'Content-Type: application/json'
    );
    $options = array(
        'http' => array(
            'header' => $header,
            'method' => $method,
            'content' => $param
        )
    );
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);

    return $result;
}

// Get the 'event' query parameter from the URL
$eventParam = isset($_GET['query']) ? $_GET['query'] : '';

if (empty($eventParam)) {
    // If the 'event' parameter is empty, return an empty array
    echo json_encode(['hasil' => []]);
    exit();
}

// Prepare the Elasticsearch query to filter by 'event' field
$params = [
    'size' => 1000, // Adjust the size to match the maximum number of documents to retrieve
    'query' => [
        'match' => [
            'event' => $eventParam,
        ],
    ],
    '_source' => ['narasumber', 'judul', 'deskripsi_pendek', 'url_youtube'],
];

$query = json_encode($params);
$response = query($url, 'POST', $query);

// Extract search results
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