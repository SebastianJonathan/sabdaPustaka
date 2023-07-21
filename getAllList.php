<?php
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

function extractUniqueSpeakers($hits)
{
    $uniqueNames = [];

    foreach ($hits as $hit) {
        $source = $hit['_source'];
        $names = explode(", ", $source['narasumber']);

        foreach ($names as $participantName) {
            $cleanedName = trim($participantName);
            if (!in_array($cleanedName, $uniqueNames)) {
                $uniqueNames[] = $cleanedName;
            }
        }
    }

    return $uniqueNames;
}



// Set the Elasticsearch index name and endpoint URL
$index = 'pustaka5';
$url = 'http://localhost:9200/' . $index . '/_search';

// Query to retrieve all documents
$params = [
    'size' => 1000, // Adjust the size to match the maximum number of documents to retrieve
    'query' => [
        'match_all' => new \stdClass() // Empty query to retrieve all documents
    ],
    '_source' => ['narasumber', 'event'] // Include only 'narasumber' and 'event' fields in the response
];

$query = json_encode($params);
$response = query($url, 'POST', $query);

// Extract unique 'narasumber' and 'event' values
$hits = $response['hits']['hits'];
$narasumbers = extractUniqueSpeakers($hits);
$events = [];

foreach ($hits as $hit) {
    $source = $hit['_source'];

    if (isset($source['event']) && !in_array($source['event'], $events)) {
        $events[] = $source['event'];
    }
}

sort($events);
sort($narasumbers);

?>

<head>
    <?php
    include 'header.php';
    ?>
    <!-- Add your CSS styles and other head elements here -->
    <link rel="stylesheet" href="getalllist.css">
</head>

<body>
    <?php
    include 'navbar.php';
    ?>

    <div class="container mt-5">
        <div class="container-event">
            <div class="row">
                <div class="col-md-12 event-name">
                    <h2 class="text-center">Semua Event</h2>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($events as $event) {
                    // Generate the link with the event as a query parameter
                    $eventUrl = 'related_results.php?event=' . urlencode($event);
                    echo '<div class="col-md-2 event-li"><a href="' . $eventUrl . '">' . $event . '</a></div>';
                }
                ?>
            </div>
        </div>

        <div class="container-event">
            <div class="row">
                <div class="col-md-12 event-name">
                    <h2 class="text-center">Semua Narasumber</h2>
                </div>
            </div>
            <!-- Wrap the entire narasumber container with a parent container -->
            <div class="container-expandable">
                <div class="row">
                    <?php
                    foreach ($narasumbers as $narasumber) {
                        // Generate the link with the narasumber as a query parameter
                        $narasumberUrl = 'related_results.php?narasumber=' . urlencode($narasumber);

                        // Narasumber name
                        echo '<div class="col-md-3 narsum-li"><a href="' . $narasumberUrl . '">' . $narasumber . '</a></div>';
                    }
                    ?>
                </div>
            </div>
            <!-- Add the "V" shaped button at the bottom of the container -->
            <div class="expand-button">
                <a href="#" class="expand-toggle">&#x25BC;</a>
            </div>
        </div>
    </div>

    <script>
        // Get the container and the "V" shaped button
        const containerExpandable = document.querySelector('.container-expandable');
        const expandToggle = document.querySelector('.expand-toggle');

        expandToggle.addEventListener('click', () => {
            // Toggle the visibility of the container
            if (containerExpandable.style.display === 'none') {
                containerExpandable.style.display = 'block';
            } else {
                containerExpandable.style.display = 'none';
            }
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>