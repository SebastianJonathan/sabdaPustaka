<?php

function query($url, $param)
{
    $header = array(
        'Content-Type: application/json'
    );
    $options = array(
        'http' => array(
            'header' => $header,
            'method' => 'POST',
            'content' => $param
        )
    );
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response, true);

    return $result;
}

function getYoutubeVideoId($url)
{
    $pattern = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    $matches = [];
    preg_match($pattern, $url, $matches);

    if (isset($matches[1])) {
        return $matches[1]; // YouTube video ID
    } else {
        return null; // Invalid YouTube URL or ID not found
    }
}

echo '<div class="_cards-container">';
echo '<div class="main">';
echo '<ul class="_cards">';

if (isset($_POST['query'])) {
    $query = $_POST['query'];

    $url = 'http://localhost:9200/pustaka5/_search';
    $queryValue = $_POST['query'];

    $checkbox_judul = isset($_POST['checkbox_judul']);
    $checkbox_narasumber = isset($_POST['checkbox_narasumber']);
    $checkbox_event = isset($_POST['checkbox_event']);

    $mustClause = [];

    if ($checkbox_judul || $checkbox_narasumber || $checkbox_event) {
        $multiMatch = [
            'query' => $queryValue,
            'operator' => 'and',
            'fuzziness' => 'AUTO'
        ];

        $fields = [];

        if ($checkbox_judul) {
            $fields[] = 'judul_completion.input';
        }
        if ($checkbox_narasumber) {
            $fields[] = 'narasumber_completion.input';
        }
        if ($checkbox_event) {
            $fields[] = 'event_completion.input';
        }

        $multiMatch['fields'] = $fields;
        $mustClause[] = ['multi_match' => $multiMatch];
    }

    $query = [
        'query' => [
            'bool' => [
                'must' => $mustClause
            ]
        ]
    ];

    $response = query($url, json_encode($query));

    if (isset($response['hits']['hits'])) {
        $hits = $response['hits']['hits'];
        foreach ($hits as $hit) {
            $source = $hit['_source'];
            $judul = $source['judul'];
            $narasumber = $source['narasumber'];
            $deskripsi_pendek = $source['deskripsi_pendek'];
            $documentId = $hit['_id'];

            echo '<li class="_cards_item">';
            echo '<div class="_card" onclick="window.location.href=\'selected_card.php?document_id=' . $documentId . '\'">';
            // echo '<div class="card_image"><img src="https://picsum.photos/500/300/?image=10"></div>';
            echo '<div class="_card_image">';
            if (isset($source['url_youtube'])) {
                $youtubeUrl = $source['url_youtube'];
                // Extract the YouTube video ID from the URL
                $videoId = getYoutubeVideoId($youtubeUrl);
                if ($videoId) {
                    $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                    echo '<img src="' . $thumbnailUrl . '">';
                }
            }
            echo '</div>';
            echo '<div class="_card_content">';
            echo '<h2 class="_card_title">' . $judul . '</h2>';
            echo '<p class="_card_text">' . $narasumber . '</p>';
            // echo '<a class="card_link" href="selected_card.php?document_id=' . $documentId . '"></a>';
            // echo '<a class="card_link" data-document-id="' . $documentId . '">View Details</a>';
            echo '</div>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '</ul>';
        echo "No results found.";
    }
}



echo '</div>';
echo '</div>';

?>

<!-- <script>
// Get all the card links
const cardLinks = document.querySelectorAll('.card_link');
// Add click event listeners to each card link
cardLinks.forEach(function(cardLink) {
    cardLink.addEventListener('click', function() {
        const documentId = this.dataset.documentId;
        const url = `selected_card.php?document_id=${documentId}`;
        window.location.href = url;
    });
});
</script> -->