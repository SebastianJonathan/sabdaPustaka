<?php
// include '../CONFIG/config.php';
// $url = $configElasticPath . $indexName . '/_search';
// include '../API/query.php';

// function extractUniqueSpeakers($hits)
// {
//     $uniqueNames = [];

//     foreach ($hits as $hit) {
//         $source = $hit['_source'];
//         $names = "";
//         $name = $source['narasumber'];
//         $name = str_replace(",S.","|S.",$name);
//         $name = str_replace(", S.","| S.",$name);
//         $name = str_replace(",M.","|M.",$name);
//         $name = str_replace(", M.","| M.",$name);
//         $name = str_replace(",Ph.","|Ph.",$name);
//         $name = str_replace(", Ph.","| Ph.",$name);
//         $names = $name;
//         $names = explode(", ", $names);

//         foreach ($names as $participantName) {
//             $cleanedName = trim($participantName);
//             $cleanedName = str_replace("|",",",$cleanedName);
//             if (!in_array($cleanedName, $uniqueNames)) {
//                 $uniqueNames[] = $cleanedName;
//             }
//         }
//     }

//     return $uniqueNames;
// }

// // Query to retrieve all documents
// $params = [
//     'size' => 1000, // Adjust the size to match the maximum number of documents to retrieve
//     'query' => [
//         'match_all' => new \stdClass() // Empty query to retrieve all documents
//     ],
//     '_source' => ['narasumber', 'event'] // Include only 'narasumber' and 'event' fields in the response
// ];

// $query = json_encode($params);
// $response = query($url, $query);

// // Extract unique 'narasumber' and 'event' values
// $hits = $response['hits']['hits'];
// $narasumbers = extractUniqueSpeakers($hits);
// $events = [];

// foreach ($hits as $hit) {
//     $source = $hit['_source'];

//     if (isset($source['event']) && !in_array($source['event'], $events)) {
//         $events[] = $source['event'];
//     }
// }

// sort($events);
// sort($narasumbers);

?>
<?php //include 'header.php'; ?>

<!-- <div id="p4_allList">
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
            <!-- Wrap the entire narasumber container with a parent container 
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
            Add the "V" shaped button at the bottom of the container 
            <div class="expand-button">
                <a href="#" class="expand-toggle">&#x25BC;</a>
            </div>
        </div>
    </div>
</div> -->
    
<?php //include 'footer.php'; ?>