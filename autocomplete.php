<?php
    if(strlen($_GET['query']) >= 3){
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

        $url = 'http://localhost:9200/pustaka7/_search';

        $fields = explode(',', $_GET['fields']);
        print_r($fields);

        $params = [
            'size' => 10,
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'multi_match' => [
                                'query' => $_GET['query'],
                                'fields' => $fields,
                                'operator' => 'and'
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

        $rekomendasiTerkaitJudul = array();
        $rekomendasiUtamaJudul = array();
        $rekomendasiTerkaitEvent = array();
        $rekomendasiUtamaEvent = array();
        $rekomendasiTerkaitNarasumber = array();
        $rekomendasiUtamaNarasumber = array();
        $related = array();
        $queryy = $_GET['query'];

        // Loop through the hits
        foreach ($hits as $hit) {
            $source = $hit['_source'];
            $event = $source['event'];
            $judul = $source['judul'];
            $narasumber = $source['narasumber'];

            $highlight = $hit['highlight'];

            if (isset($highlight['judul_completion.input']) && !in_array($judul, $rekomendasiTerkaitJudul) && !in_array($judul, $rekomendasiUtamaJudul)) {
                if(strtolower(substr($judul,0,strlen($queryy))) == strtolower($queryy)){
                    $rekomendasiUtamaJudul[] = $judul;
                }
                else{
                    $rekomendasiTerkaitJudul[] = $judul;
                }
            }
            
            else if (isset($highlight['event_completion.input']) && !in_array($event, $rekomendasiTerkaitEvent) && !in_array($event, $rekomendasiUtamaEvent)) {
                if(strtolower(substr($event,0,strlen($queryy))) == strtolower($queryy)){
                    $rekomendasiUtamaEvent[] = $event;
                }
                else{
                    $rekomendasiTerkaitEvent[] = $event;
                }
            }

            else if (isset($highlight['narasumber_completion.input'])) {
                $narasumber = str_replace(",S.","|S.",$narasumber);
                $narasumber = str_replace(", S.","| S.",$narasumber);
                $narasumber = str_replace(",B.","|B.",$narasumber);
                $narasumber = str_replace(", B.","| B.",$narasumber);
                $narasumber = str_replace(",M.","|M.",$narasumber);
                $narasumber = str_replace(", M.","| M.",$narasumber);
                $narasumber = str_replace(",Ph.","|Ph.",$narasumber);
                $narasumber = str_replace(", Ph.","| Ph.",$narasumber);
                $listNarasumber = explode(", ",$narasumber);
                foreach($listNarasumber as $namaNarasumber){
                    $namaNarasumber = str_replace("|",",",$namaNarasumber);
                    if(stripos($namaNarasumber,$_GET['query']) !== false && !in_array($namaNarasumber, $rekomendasiTerkaitNarasumber) && !in_array($namaNarasumber, $rekomendasiUtamaNarasumber)){
                        if(strtolower(substr($namaNarasumber,0,strlen($queryy))) == strtolower($queryy)){
                            $rekomendasiUtamaNarasumber[] = $namaNarasumber;
                        }
                        else{
                            $rekomendasiTerkaitNarasumber[] = $namaNarasumber;
                        }
                    }
                }
            }
            else if(isset($highlight['deskripsi_pendek'])){
                if(!in_array($source['judul'],$related) and !in_array($source['judul'],$rekomendasiUtamaJudul) and !in_array($source['judul'],$rekomendasiTerkaitJudul)){
                    $related[] = $source['judul'];
                }
            }
            else if(isset($highlight['ringkasan'])){
                if(!in_array($source['judul'],$related) and !in_array($source['judul'],$rekomendasiUtamaJudul) and !in_array($source['judul'],$rekomendasiTerkaitJudul)){
                    $related[] = $source['judul'];
                }
            }
            else if(isset($source['kata_kunci'])){
                if(!in_array($source['judul'],$related) and !in_array($source['judul'],$rekomendasiUtamaJudul) and !in_array($source['judul'],$rekomendasiTerkaitJudul)){
                    $related[] = $source['judul'];
                }
            }
        }   
        $rekomendasi = [
            'judul' => array_merge($rekomendasiUtamaJudul,$rekomendasiTerkaitJudul),
            'event' => array_merge($rekomendasiUtamaEvent,$rekomendasiTerkaitEvent),
            'narasumber' => array_merge($rekomendasiUtamaNarasumber,$rekomendasiTerkaitNarasumber),
            'related' => $related
        ];
        header('Content-Type: application/json');
        echo json_encode(['rekomendasi' => $rekomendasi]);
    }else{
        $rekomendasi = [
            'judul' => [],
            'event' => [],
            'narasumber' => [],
            'related' => []
        ];
        header('Content-Type: application/json');
        echo json_encode(['rekomendasi' => $rekomendasi]);
    }
?>