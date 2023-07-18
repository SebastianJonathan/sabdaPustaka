<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles3.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sabdastyle.css">
    <style>
        .container-atas {
            background-color: #FFF;
            margin-top: 10px;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 10px;
        }

        .container-bawah {
            margin-bottom: 30px;
            padding: 30px;
        }

        .materi-terkait h3 {
            text-align: center;
        }

        .summary-content {
            background-color: #FFFFF0;
            padding: 20px;
            border-radius: 20px;
        }

        .summary-content h2,
        h3 {
            text-align: center;
        }

        .summary-container {
            position: relative;
        }

        .pertanyaan-container {
            background-color: #FFFFF0;
            padding: 20px;
            border-radius: 20px;

            position: absolute;
            top: 0;
            bottom: 0;
            overflow-y: auto;
        }

        .container-bawah h3 {
            font-size: medium;
        }
    </style>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const summaryContainer = document.querySelector('.summary-container');
            const pertanyaanContainer = document.querySelector('.pertanyaan-container');

            // Set the initial height of pertanyaanContainer to match summaryContainer
            pertanyaanContainer.style.height = `${summaryContainer.clientHeight}px`;

            // Adjust the height of pertanyaanContainer dynamically if its content exceeds summaryContainer
            const adjustPertanyaanContainerHeight = () => {
                const summaryHeight = summaryContainer.clientHeight;
                const pertanyaanHeight = pertanyaanContainer.scrollHeight;

                if (pertanyaanHeight > summaryHeight) {
                    pertanyaanContainer.style.height = `${pertanyaanHeight}px`;
                }
            };

            // Call the adjustPertanyaanContainerHeight function whenever the window is resized
            window.addEventListener('resize', adjustPertanyaanContainerHeight);
        });
    </script>
</head>

<body>
    <?php

    include 'navbar.php';

    function getSlideShareKey($url)
    {
        $urlParts = explode("/", $url);
        $key = end($urlParts);
        return $key;
    }

    // include 'query_function.php';
    function query($url, $param)
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
        $response = query($url, null);

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

            $pertanyaan = explode(', ', $list_pertanyaan);
            $katakunci = explode(', ', $kata_kunci);
    ?>

            <div class="container-fluid">
                <!-- Container Atas -->
                <div class="container-atas">
                    <div class="row">
                        <!-- Container Thumbnail -->
                        <div class="col-lg-6">
                            <div class="video-container">
                                <div class="video-wrapper">
                                    <!-- <iframe width="100%" height="315" src="<?php echo $url_youtube; ?>" frameborder="0" allowfullscreen></iframe> -->
                                    <iframe src="<?php echo $url_static ?>" width="100%" height="400px"></iframe>
                                    <a href="<?php echo $url_slideshare ?>" target="_blank">Link to SlideShare</a>
                                </div>
                            </div>
                        </div>
                        <!-- Container Details Judul dll -->
                        <div class="col-lg-6">
                            <div class="details-container">
                                <div class="details-content">
                                    <h2><?php echo $judul; ?></h2>
                                    <p><span class="label"></span> <span class="value"><?php echo $narasumber; ?></p>
                                    <p><span class="label"></span><span class="value"> <?php echo $tanggal; ?></p>
                                    <p><span class="label"></span> <?php echo $deskripsi_pendek; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bawah -->
                <div class="container-bawah">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="summary-content">
                                    <h2>Ringkasan</h2>
                                    <?php echo $ringkasan; ?>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="keyword-content">
                                    <h6>Keywords</h6>
                                    <?php
                                    foreach ($katakunci as $item) {
                                        $link = 'javascript:void(0);'; // Set the link to javascript:void(0);
                                        echo "<a href=\"$link\" class=\"keyword-link\" data-keyword=\"$item\" style=\"color: blue;\">$item</a> " . ". ";
                                    }
                                    ?>


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="pertanyaan-container" id="pertanyaan-container">
                                <h3>Pertanyaan Renungan</h2>
                                    <div class="pertanyaan-content" id="pertanyaan-content">
                                        <ul>
                                            <?php
                                            foreach ($pertanyaan as $item) {
                                                echo "<li>" . $item . "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="materi-terkait">
                        <h3>Materi Terkait</h3>
                        <?php

                        ?>
                    </div>
                </div>
            </div>
            <script>

            </script>
    <?php
        } else {
            echo "Document not found.";
        }
    }
    ?>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const keywordLinks = document.querySelectorAll('.keyword-link');

        keywordLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const query = link.dataset.keyword;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'related_results.php';

                const keywordInput = document.createElement('input');
                keywordInput.type = 'hidden';
                keywordInput.name = 'keyword';
                keywordInput.value = query;

                form.appendChild(keywordInput);

                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
</body>

<?php
include 'coba3.php';
?>

</html>
