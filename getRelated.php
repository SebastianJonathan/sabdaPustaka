<?php
if (isset($_POST['document_id'])) {
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

    $documentId = $_POST['document_id'];
    $url = 'http://localhost:9200/pustaka5/_search';

    $params = [
        'size' => 5,
        'query' => [
            'bool' => [
                'must' => [
                    [
                        'range' => [
                            '_id' => [
                                'gt' => $documentId
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'sort' => [
            '_id' => 'asc'
        ]
    ];
    
    $query = json_encode($params);
    $response = query($url, $query);
    $hits = $response['hits']['hits'];

    $relatedResults = [];

    foreach ($hits as $hit) {
        $source = $hit['_source'];
        $judul = $source['judul'];
        $narasumber = $source['narasumber'];

        $relatedResults[] = [
            'judul' => $judul,
            'narasumber' => $narasumber
        ];
    }

    echo json_encode(['related_results' => $relatedResults]);
}
