<?php
include '../CONFIG/config.php';
$url = $configElasticPath . $indexName . '/_search';
include 'query.php';


if (isset($_GET['document_id'])) {
    $documentId = $_GET['document_id'];

    // Prepare the query parameters
    $params = [
        'query' => [
            'more_like_this' => [
                'fields' => ['kata_kunci'], // Adjust the fields based on your preference
                'like' => [
                    [
                        '_index' => $indexName,
                        '_id' => $documentId
                    ]
                ],
                'min_term_freq' => 1,
                'max_query_terms' => 4, // Adjust the number of terms based on your preference
                'minimum_should_match' => '60%'
            ]
        ],
        'size' => 4 // Adjust the number of related documents to retrieve
    ];

    $query = json_encode($params);
    $response = query($url, $query);

    // Extract the related documents

    if ($response === "E-CONN"){
        echo $response;
    }else{
        $relatedDocuments = $response['hits']['hits'];

        if (sizeof($relatedDocuments) > 0){
            echo '<div class = "_cards-container">';
            echo '<div class = "main">';
            echo '<ul class = "_cards" id="card_result">';
        
            // Output the related documents
            foreach ($relatedDocuments as $document) {
                $event = $document['_source']['event'];
                $judul = $document['_source']['judul'];
                $narasumber = $document['_source']['narasumber'];
        
                echo '<li class="_cards_item">';
                echo '<div class="_card" onclick="window.location.href=\'selected_card.php?document_id=' . $document['_id'] . '\'">';
                echo '<div class="_card_image">';
                
                if (isset($document['_source']['url_youtube'])) {
                    $youtubeUrl = $document['_source']['url_youtube'];
                    $videoId = getYoutubeVideoId($youtubeUrl);
                    if ($videoId) {
                        $thumbnailUrl = 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
                        echo '<img src="' . $thumbnailUrl . '" alt="Card Image">';
                    }
                }
                
                echo '</div>';
                echo '<div class="_card_content">';
                echo '<a class="_card_text" href="' . $configPath . 'PHP/related_results.php?event=' . urlencode($event) . '" style="text-decoration: none;">' . $event . '</a>';
                echo '<h2 class="_card_title">' . $judul . '</h2>';
                // echo '<p class="_card_text">' . $narasumber . '</p>';

                // narasumber
                $narasumberArray = explode(', ', $narasumber); // Split values into an array
                echo '<div style="display: block;" id="divNarsum">';
                $count = 0;
                $totalNarasumbers = count($narasumberArray);
                
                foreach ($narasumberArray as $element) {
                    echo '<a class="_card_text" href="' . $configPath . 'php/related_results.php?narasumber=' . urlencode($element) . '" style="text-decoration: none;">';
                
                    echo $element;
                
                    if ($count < $totalNarasumbers - 1) {
                        echo ',';
                    }
                
                    echo '</a>';
                
                    $count++;
                }

                echo '</div>';
                echo '</div>';
                echo '</li>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        
        }
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
