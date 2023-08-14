<?php
include '../CONFIG/config.php';
if (isset($_GET['document_id'])) {
    $documentId = $_GET['document_id'];
    
    // Set up Elasticsearch connection
    $hostPort = $configElasticPath;
    $index = $indexName;
    $url = "{$hostPort}{$index}/_search";

    // Prepare the query parameters
    $params = [
        'query' => [
            'more_like_this' => [
                'fields' => ['ringkasan'], // Adjust the fields based on your preference
                'like' => [
                    [
                        '_index' => $index,
                        '_id' => $documentId
                    ]
                ],
                'min_term_freq' => 1,
                'max_query_terms' => 12, // Adjust the number of terms based on your preference
                'minimum_should_match' => '30%'
            ]
        ],
        'size' => 4 // Adjust the number of related documents to retrieve
    ];

    // Execute the Elasticsearch query
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($params))
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    // Parse the Elasticsearch response
    $result = json_decode($response, true);

    // Extract the related documents
    $relatedDocuments = $result['hits']['hits'];

    if (sizeof($relatedDocuments) > 0 ){
        echo '<h3>Materi Terkait</h3>';
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
            // echo '<p class="_card_text">' . $event . '</p>';
            echo '<a class="_card_text" href="' . $configPath . 'PHP/related_results.php?event=' . urlencode($event) . '" style="text-decoration: none;">' . $event . '</a>';
            echo '<h2 class="_card_title">' . $judul . '</h2>';
            // echo '<p class="_card_text">' . $narasumber . '</p>';

            // narasumber
            $narasumberArray = explode(',', $narasumber); // Split values into an array
            echo '<div style="display: block;" id="divNarsum">';
            $count = 0;
            foreach ($narasumberArray as $element) {
                echo '<a class="_card_text" style="text-decoration: none;">';
                
                if ($count < count($narasumberArray) - 1) {
                    echo $element . ', ';
                } else {
                    echo $element;
                }
                
                echo '</a>';
                
                // Generate a unique click event listener for each _card_text element
                echo '<script>
                    document.querySelector("#divNarsum a:nth-child(' . ($count + 1) . ')").onclick = function(event){
                        window.location.href = "' . $configPath . 'PHP/related_results.php?narasumber=' . urlencode($element) . '";
                        event.stopPropagation();
                    };
                </script>';
                $count++;
            }
            echo '</div>';

            echo '</div>';
            echo '</div>';
            echo '</li>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
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
