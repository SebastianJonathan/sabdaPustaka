<?php
include '../CONFIG/config.php';
$url = $configElasticPath . $indexName . '/_search';
include 'query.php';
if (isset($_GET['document_id'])) {
    $documentId = $_GET['document_id'];

    // Prepare the query parameters
    $params = [
        'query' => [
            'function_score' => [
                'query' => [
                    'more_like_this' => [
                        'fields' => ['judul'], // Adjust the fields based on your preference
                        'like' => [
                            [
                                '_index' => $indexName,
                                '_id' => $documentId
                            ]
                        ],
                        'min_term_freq' => 1,
                        'max_query_terms' => 5, // Adjust the number of terms based on your preference
                        'minimum_should_match' => '10%'
                    ]
                ],
                'random_score' => [
                    'seed' => time(), // Use a seed for randomization
                ],
                'boost_mode' => 'multiply', // This will maintain the minimum_should_match condition
            ],
        ],
        'size' => 4, // Adjust the number of related documents to retrieve
        '_source' => ['event','narasumber', 'judul', 'deskripsi_pendek', 'url_youtube', 'ringkasan'],
    ];

    $query = json_encode($params);
    $response = query($url, $query);

    if ($response === "E-CONN"){
        echo $response;
    }else{
        $relatedDocuments = $response['hits']['hits'];
        echo json_encode(['result' => $relatedDocuments]);
    }
}

function getYoutubeVideoId($url) {
    $pattern = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    preg_match($pattern, $url, $matches);

    if (isset($matches[1])) {
        return $matches[1]; // YouTube video ID
    } else {
        return null; // Invalid YouTube URL or ID not found
    }
}
?>
