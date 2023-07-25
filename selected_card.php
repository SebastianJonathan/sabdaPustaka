<!DOCTYPE html>
<html lang="en">

<head>
  <title>Document</title>
  <?php include 'header.php' ?>
  <link rel="stylesheet" href="selected_card.css">
  <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.7.570/build/pdf.min.js"></script>
  <script defer>
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
          entry.target.classList.add('_show');
        } else {
          entry.target.classList.remove('_show');
        }
      });
      threshold = 0.1;  
    });

    document.addEventListener("DOMContentLoaded", function() {
      console.log("t");
      const hiddenElements = document.querySelectorAll('._hidden');
      console.log(hiddenElements);
      hiddenElements.forEach((el) => observer.observe(el));
      // Rest of your code here...
    });
  </script>
  <style>
    ._hidden {
      opacity: 0;
      filter: blur(5px);
      transform: translateY(40%);
      transition: all 0.5s;
    }

    ._show {
      opacity: 1;
      filter: blur(0);
      transform: translateX(0);
    }
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <?php
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

    $url = 'http://localhost:9200/pustaka7/_doc/' . $documentId;
    $response = query($url, null);

    if (isset($response['_source'])) {
      $source = $response['_source'];
      $event = $source['event'];
      $judul = $source['judul'];
      $tanggal = $source['tanggal'];
      $url_youtube = $source['url_youtube'];
      $url_static = $source['url_static'];
      $url_slideshare = $source['url_slideshare'];
      $slideshare_key = getSlideShareKey($url_slideshare);
      $narasumber = $source['narasumber'];
      $narasumber = str_replace('*', '.', $source['narasumber']);

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
      $pembicara = str_replace(",S.","|S.",$pembicara);
      $pembicara = str_replace(", S.","| S.",$pembicara);
      $pembicara = str_replace(",B.","|B.",$pembicara);
      $pembicara = str_replace(", B.","| B.",$pembicara);
      $pembicara = str_replace(",M.","|M.",$pembicara);
      $pembicara = str_replace(", M.","| M.",$pembicara);
      $pembicara = str_replace(",Ph.","|Ph.",$pembicara);
      $pembicara = str_replace(", Ph.","| Ph.",$pembicara);
      $pembicara = explode(',', $narasumber);
  ?>

      <div class="container-fluid">
        <!-- PPT & Ringkasan -->
        <div class="row container-atas  _hidden">
          <div class="col-lg-6" style="padding:7px;">
            <?php
            if ($url_static) {
            ?>
              <iframe src="<?php echo $url_static ?>" width="100%" height="400px"></iframe>
            <?php
            } else {
            ?>
              <div class="error-message" style="padding:7px;">
                <p class="text-center">Tampilan Presentasi belum ada, silahkan pergi ke <a href="<?php echo $url_slideshare ?>" target="_blank">link ini</a></p>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="col-lg-6" style>
            <div class="details-container">
              <div class="details-content">
                <h2><?php echo $judul; ?></h2>

                <!-- Narasumer & Tanggal -->
                <div class="narsum-tanggal">
                  <p><span class="label"></span><span class="value" style="font-weight: bold;"><?php echo $event; ?></p>
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

                <!-- Deskripsi Pendek -->
                <p><span class="label"></span> <?php echo $deskripsi_pendek; ?></p>

                <!-- Button YT & SlideShare -->
                <span>
                  <button type="button" class="btn-ln">
                    <a href="<?php echo $url_youtube ?>" class="btn-ln-a" target="_blank">Tonton Presentasi</a>
                  </button>
                  <button type="button" class="btn-ln">
                    <a href="<?php echo $url_slideshare ?>" class="btn-ln-a" target="_blank">Link Presentasi</a>
                  </button>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Ringkasan -->
        <div class="row container-bawah">
          <div class="col-lg-9 sum-col">
            <div class="row">
              <div class="summary-content  _hidden" style="margin-bottom: 10px;">
                <h2>Ringkasan</h2>
                <?php echo $ringkasan; ?>
              </div>
            </div>
            <div class="row">
              <div class="keyword-content  _hidden">
                <h5>Kata Kunci</h5>
                <div class="links">
                  <?php
                  foreach ($katakunci as $item) {
                    $link = 'javascript:void(0);'; // Set the link to javascript:void(0);
                    echo "<a href=\"$link\" class=\"keyword-link\" data-keyword=\"$item\"\">$item</a> ";
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 q-col">
            <div class="pertanyaan-container _hidden" id="pertanyaan-container">
              <h5 class="text-center">Pertanyaan Renungan</h5>
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
        <!-- Materi Terkait -->
        <div class="row materi-terkait">
          <div class="materi-text">
            <section class="_hidden">
              <h3>Materi Terkait</h3>
              <div id="related-results-container"></div>
            </section>
          </div>
        </div>

      </div>


    <?php
    } else {
    ?>
      <br>
      <h1>Document not found<h1><br>
        <?php
      }
    } else {
        ?>
        <br>
        <h1>Document not found<h1><br>
          <?php
        }
          ?>

          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
          <script>
            /* 
          FETCH KEYWORD DI BUTTON > PINDAH KE RELATED_RESULTS.PHP
      */
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

            /* 
                FETCH NARSUM DI BUTTON > PINDAH KE RELATED_RESULTS.PHP
            */

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
          <?php
          include 'footer.php';
          ?>
</body>



</html>