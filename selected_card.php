<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="selected_card.css">
    <script>
        function goBack() {
            window.history.go(-1);
            // Scroll to the top of the page
            window.scrollTo(0, 0);
            // Restore scroll position if supported by the browser
            if ('scrollRestoration' in window.history) {
                window.history.scrollRestoration = 'manual';
            }
        }
    </script>
</head>

<body>
    <?php
    function getSlideShareKey($url)
    {
        $urlParts = explode("/", $url);
        $key = end($urlParts);
        return $key;
    }

    // include 'query_function.php';
    function query($url)
    {
        $header = array(
            'Content-Type: application/json'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);

        return $result;
    }

    if (isset($_GET['document_id'])) {
        $documentId = $_GET['document_id'];

        $url = 'http://localhost:9200/pustaka5/_doc/' . $documentId;
        $response = query($url);

        if (isset($response['_source'])) {
            $source = $response['_source'];
            $judul = $source['judul'];
            $tanggal = $source['tanggal'];
            $url_youtube = $source['url_youtube'];
            $url_static = $source['url_static'];
            $url_slideshare = $source['url_slideshare'];
            $slideshare_key = getSlideShareKey($url_slideshare);
            $narasumber = $source['narasumber'];
            $ringkasan = $source['ringkasan'];
            $deskripsi_pendek = $source['deskripsi_pendek'];
            $kata_kunci = $source['kata_kunci'];
            $list_pertanyaan = $source['list_pertanyaan'];
    ?>
            <div class="container">
                <div class="search-bar">
                    <?php include 'search_bar.php'; ?>
                </div>
                <div class="event-details">
                    <!-- <h1>Event Details</h1> -->
                    <div class="content-container">
                        <div class="video-container">
                            <iframe width="100%" height="315" src="<?php echo $url_youtube; ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class="details-container">
                            <div class="details-content">
                                <h2><?php echo $judul; ?></h2>
                                <p><span class="label"></span> <span class="value"><?php echo $narasumber; ?></p>
                                <p><span class="label"></span><span class="value"> <?php echo $tanggal; ?></p>
                                <p><span class="label"></span> <?php echo $deskripsi_pendek; ?></p>
                                <a href="<?php echo $url_slideshare?>" target="_blank">Link to SlideShare</a>
                            </div>
                        </div>
                    </div>
                    <div class="summary-container">
                        <div class="summary-content">
                            <h2>Summary</h2>
                            <?php echo $ringkasan; ?>
                        </div>
                    </div>
                </div>
            </div>

    <?php
        } else {
            echo "Document not found.";
        }
    }

    ?>

</body>

<?php
    include 'coba3.php';
?>
</html>