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
$narasumbers = [];
$events = [];

foreach ($hits as $hit) {
    $source = $hit['_source'];

    if (isset($source['narasumber']) && !in_array($source['narasumber'], $narasumbers)) {
        $narasumbers[] = $source['narasumber'];
    }

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
    <style>
        /* Custom styles for the list */

        .container-event {
            color: gold;
            margin-top: 50px;
            background: linear-gradient(to right top, #1e0049, #211045, #251c3f, #2a2638, #2f2f2f);
            padding: 20px;
            border-radius: 30px;
        }


        .container-event a {
            color: white;
            text-decoration: none;
        }

        a:hover {
            color: gold;
        }

        .event-li {
            margin-bottom: 10px;
        }

        .event-name {
            margin-bottom: 15px;
        }

        .event-name h2 {
            font-weight: bold;
        }

        .event-li a {
            font-size: large;
        }
    </style>
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
            <div class="row">
                <?php
                foreach ($narasumbers as $narasumber) {
                    // Generate the link with the narasumber as a query parameter
                    $narasumberUrl = 'related_results.php?narasumber=' . urlencode($narasumber);
                    echo '<div class="col-md-2 narsum-li"><a href="' . $narasumberUrl . '">' . $narasumber . '</a></div>';
                }
                ?>
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>
</body>

</html>