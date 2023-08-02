<?php
include 'DATA/API/config.php';
$url = $configElasticPath . $indexName . '/_search';
include 'query.php';

function extractUniqueSpeakers($hits)
{
    $uniqueNames = [];

    foreach ($hits as $hit) {
        $source = $hit['_source'];
        $names = "";
        $name = $source['narasumber'];
        $name = str_replace(",S.","|S.",$name);
        $name = str_replace(", S.","| S.",$name);
        $name = str_replace(",M.","|M.",$name);
        $name = str_replace(", M.","| M.",$name);
        $name = str_replace(",Ph.","|Ph.",$name);
        $name = str_replace(", Ph.","| Ph.",$name);
        $names = $name;
        $names = explode(", ", $names);

        foreach ($names as $participantName) {
            $cleanedName = trim($participantName);
            $cleanedName = str_replace("|",",",$cleanedName);
            if (!in_array($cleanedName, $uniqueNames)) {
                $uniqueNames[] = $cleanedName;
            }
        }
    }

    return $uniqueNames;
}

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
                <ul id="eventList"></ul>
                <?php
                // foreach ($events as $event) {
                //     // Generate the link with the event as a query parameter
                //     $eventUrl = 'related_results.php?event=' . urlencode($event);
                //     echo '<div class="col-md-2 event-li"><a href="' . $eventUrl . '">' . $event . '</a></div>';
                // }
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
                    // foreach ($narasumbers as $narasumber) {
                    //     // Generate the link with the narasumber as a query parameter
                    //     $narasumberUrl = 'related_results.php?narasumber=' . urlencode($narasumber);

                    //     // Narasumber name
                    //     echo '<div class="col-md-3 narsum-li"><a href="' . $narasumberUrl . '">' . $narasumber . '</a></div>';
                    // }
                    ?>
                    <ul id="narasumberList"></ul>
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
		const events = <?php echo json_encode($events); ?>;
		const narasumbers = <?php echo json_encode($narasumbers); ?>;


        expandToggle.addEventListener('click', () => {
            // Toggle the visibility of the container
            if (containerExpandable.style.display === 'none') {
                containerExpandable.style.display = 'block';
            } else {
                containerExpandable.style.display = 'none';
            }
        });

        function generateEventLinks() {
			const eventListContainer = document.getElementById('eventList');
			events.forEach((event) => {
				const eventUrl = configPath + 'related_results.php?event=' + encodeURIComponent(event);
				const eventDiv = document.createElement('li');
				eventDiv.className = 'event-li';
				// eventDiv.style.width = "150px";
				eventDiv.innerHTML = `<a href="${eventUrl}">${event}</a>`;
				eventListContainer.appendChild(eventDiv);
			});
		}

		function generateNarasumberLinks() {
			const narasumberListContainer = document.getElementById('narasumberList');
			narasumbers.forEach((narasumber) => {
				const narasumberUrl = configPath + 'related_results.php?narasumber=' + encodeURIComponent(narasumber);
				const narasumberDiv = document.createElement('li');
				narasumberDiv.className = 'narsum-li';
				// narasumberDiv.style.width = '150px';
				narasumberDiv.innerHTML = `<a href="${narasumberUrl}">${narasumber}</a>`;
				narasumberListContainer.appendChild(narasumberDiv);
			});
		}

        generateEventLinks();
		generateNarasumberLinks();
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>