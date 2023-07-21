<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="styles3.css"> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="sabdastyle.css">
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.7.570/build/pdf.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <style>
        body {
            background-color: #ffffff;
            background-image: linear-gradient(315deg, #ffffff 0%, #d7e1ec 74%);
            line-height: 1.6;
        }

        a.link-gap {
            margin-right: 30px;
            /* Adjust the margin value to your desired gap size */
        }

        .container-atas {
            background-color: #F8F8F8;
            color: #333333;
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
            background: #ffffff;
            padding: 20px;
            border-radius: 20px;
            font-size: 16px;
            line-height: 1.7;
        }

        .summary-content h2,
        h3 {
            color: #2b1313	;
            text-align: center;
        }

        .summary-container {
            position: relative;
        }

        .pertanyaan-container {
            color: #2c425c;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 20px;

            position: absolute;
            top: 0;
            bottom: 0;
            overflow-y: auto;
        }

        .container-bawah h3,p,li,ul{
            font-size: medium;
            color: #2b1313	;
        }

        .error-message {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .error-message p {
            text-align: center;
        }

        .narsum-tanggal{
            /* background: #f2f3f0; */
            color: #2c425c;
        }

        .keyword-content{
            background: #ffffff;
            padding: 20px;
            border-radius: 20px;
            font-size: 16px;
            line-height: 1.7;
        } 

        .keyword-content h6{
            margin-left: 5px;
            margin-bottom: 20px;
        }

        .keyword-link{
            color: linear-gradient(to right top, #1e0049, #211045, #251c3f, #2a2638, #2f2f2f);
            text-decoration: none;
            margin-right: 10px;
        }

        .btn-link1{
            padding: 10px 15px 10px 15px;
            border-radius: 20px;
            font-size: 16px;
            background: linear-gradient(to right top, #1e0049, #211045, #251c3f, #2a2638, #2f2f2f);
            text-decoration: none;
            margin-right: 10px;
            color: white;
        }

        .btn-link1:hover{
            color: gold;
            text-decoration: none;
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

        $url = 'http://localhost:9200/pustaka6/_doc/' . $documentId;
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
            $ringkasan = str_replace('*', "<br>", $ringkasan);

            $deskripsi_pendek = $source['deskripsi_pendek'];
            $deskripsi_pendek = str_replace('*', "<br>", $deskripsi_pendek);

            $kata_kunci = $source['kata_kunci'];
            $list_pertanyaan = $source['list_pertanyaan'];
            $list_pertanyaan = str_replace('*', "", $list_pertanyaan);
            $list_pertanyaan = str_replace(', ', "", $list_pertanyaan);

            $pertanyaan = explode('?', $list_pertanyaan);
            $katakunci = explode(', ', $kata_kunci);
            $pembicara = explode(',', $narasumber);
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
                                    <?php if ($url_static) : ?>
                                        <iframe src="<?php echo $url_static ?>" width="100%" height="400px"></iframe>
                                    <?php else : ?>
                                        <div class="error-message">
                                            <p class="text-center">Tampilan Presentasi belum ada, silahkan pergi ke <a href="<?php echo $url_slideshare ?>" target="_blank">link ini</a></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Container Details Judul dll -->
                        <div class="col-lg-6">
                            <div class="details-container">
                                <div class="details-content">
                                    <h2><?php echo $judul; ?></h2>

                                    <div class="narsum-tanggal">
                                        <?php
                                        echo "Narasumber / Pembicara:   ";
                                        foreach ($pembicara as $item) {
                                            $item = trim($item); // Trim any extra whitespace
                                            if ($item !== '') {
                                                $link = 'javascript:void(0);'; // Set the link to javascript:void(0);
                                                echo "<a href=\"$link\" class=\"narsum-link\" data-keyword=\"$item\" style=\"color: blue;\">$item</a> " . ". ";
                                            }
                                        }
                                        ?>
                                        <p><span class="label"></span><span class="value"> Tanggal: <?php echo date('j F Y', strtotime($tanggal)); ?></p>
                                    </div>

                                    <p><span class="label"></span> <?php echo $deskripsi_pendek; ?></p>
                                    <a href="<?php echo $url_youtube ?>" class="btn-link1" target="_blank">Tonton Presentasi</a>
                                    <a href="<?php echo $url_slideshare ?>" class="btn-link1" target="_blank">Link Presentasi</a>



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
                                    <h6>Kata Kunci</h6>
                                    <?php
                                    foreach ($katakunci as $item) {
                                        $link = 'javascript:void(0);'; // Set the link to javascript:void(0);
                                        echo "<a href=\"$link\" class=\"keyword-link\" data-keyword=\"$item\"\">$item</a> ";
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
                                                if (trim($item) !== '') {
                                                    echo "<li>" . $item . "?</li>";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="materi-terkait">
                    <h3>Materi Terkait</h3>
                    <div id="related-results-container"></div>
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

        const narsumLinks = document.querySelectorAll('.narsum-link');
        narsumLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const query = link.dataset.keyword;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'related_results.php';

                const narsumInput = document.createElement('input');
                narsumInput.type = 'hidden';
                narsumInput.name = 'narasumber';
                narsumInput.value = query;

                form.appendChild(narsumInput);

                document.body.appendChild(form);
                form.submit(); // <-- Add parentheses to call the form submission function
            });
        });

        function fetchRelatedDocuments() {
            const documentId = '<?php echo $_GET['document_id']; ?>';

            fetch(`getRelated.php?document_id=${encodeURIComponent(documentId)}`)
                .then(response => response.text())
                .then(data => {
                    const relatedResultsContainer = document.getElementById('related-results-container');
                    relatedResultsContainer.innerHTML = data;
                })
                .catch(error => {
                    console.error(error);
                });
        }

        // Call the fetchRelatedDocuments function to fetch and display the related document titles
        fetchRelatedDocuments();
    </script>
</body>

<?php
include 'coba3.php';
?>

</html>
