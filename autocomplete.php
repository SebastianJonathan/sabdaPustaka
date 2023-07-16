<?php
function query($url, $param)
{
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

$url = 'http://localhost:9200/pustaka5/_search';
$fields = explode(',', $_GET['fields']);

$params = [
    'size' => 10,
    'query' => [
        'bool' => [
            'must' => [
                [
                    'multi_match' => [
                        'query' => $_GET['query'],
                        'fields' => $fields,
                        'operator' => 'and',
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ]
        ]
    ],
    'highlight' => [
        'pre_tags' => ['<strong>'],
        'post_tags' => ['</strong>'],
        'fields' => array_fill_keys($fields, new \stdClass())
    ]
];
$query = json_encode($params);
$response = query($url, $query);
$hits = $response['hits']['hits'];

// $rekomendasi = array();

$rekomendasi = array(
    'judul' => array(),
    'narasumber' => array(),
    'event' => array(),
  );

// Loop through the hits
foreach ($hits as $hit) {
    $source = $hit['_source'];
    $event = $source['event'];
    $judul = $source['judul'];
    $narasumber = $source['narasumber'];

    $highlight = $hit['highlight'];

    if (isset($highlight['judul_completion.input']) && !in_array($judul, $rekomendasi)) {
        // $rekomendasi[] = $judul;
        $rekomendasi['judul'][] = $judul;
    }
    
    if (isset($highlight['event_completion.input']) && !in_array($event, $rekomendasi)) {
        // $rekomendasi[] = $event;
        $rekomendasi['event'][] = $event;
    }

    if (isset($highlight['narasumber_completion.input']) && !in_array($narasumber, $rekomendasi)) {
        // $rekomendasi[] = $narasumber;
        $rekomendasi['narasumber'][] = $narasumber;
    }
}

// Remove duplicates from recommendations


echo json_encode(['rekomendasi' => $rekomendasi]);
?>