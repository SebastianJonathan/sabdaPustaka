<?php
include '../CONFIG/configES.php';
$url = $configElasticPath . $indexName . '/_search';
if (strlen($_GET['query']) >= 3) {
    include 'query.php';

    $params = [
        'size' => '200',
        'query' => [
            'bool' => [
                'must' => [
                    [
                        'multi_match' => [
                            'query' => $_GET['query'],
                            'fields' => ['kata_kunci_completion.input'],
                            'operator' => 'and'
                        ]
                    ]
                ]
            ]
        ],
        'highlight' => [
            'pre_tags' => ['<strong>'],
            'post_tags' => ['</strong>'],
            'fields' => ['kata_kunci_completion.input' => new \stdClass()]
        ]
    ];
    $query = json_encode($params);
    $response = query($url, $query);
    if ($response === "E-CONN"){
        echo json_encode(['hasil' => $response]);
    }else{
        $hits = $response['hits']['hits'];

        $hasil = array();

        $queryy = $_GET['query'];
        foreach ($hits as $hit) {
            $source = $hit['_source'];
            $keyword = $source['kata_kunci'];
            $listKeyword = explode(", ", $keyword);
            foreach ($listKeyword as $namaKeyword) {
                if (strtolower($namaKeyword) == strtolower($queryy)) {
                    $youtubeUrl = isset($source['url_youtube']) ? $source['url_youtube'] : '';
                    $hasil[] = [
                        'event' => $source['event'],
                        'narasumber' => $source['narasumber'],
                        'judul' => $source['judul'],
                        'deskripsi_pendek' => $source['deskripsi_pendek'],
                        'id' => $hit['_id'],
                        'youtube' => $youtubeUrl
                    ];
                    break;
                }
            }
        }
        echo json_encode(['hasil' => $hasil]);
    }
}
?>
