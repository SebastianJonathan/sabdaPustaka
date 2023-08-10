<?php include 'header.php' ?>

<div id="p2_selectedCard">
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

    $url = $configElasticPath . $indexName . '/_doc/' . $documentId;
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
      $pembicara = $source['narasumber'];
      $pembicara = str_replace(",S.", "|S.", $pembicara);
      $pembicara = str_replace(", S.", "| S.", $pembicara);
      $pembicara = str_replace(",B.", "|B.", $pembicara);
      $pembicara = str_replace(", B.", "| B.", $pembicara);
      $pembicara = str_replace(",M.", "|M.", $pembicara);
      $pembicara = str_replace(", M.", "| M.", $pembicara);
      $pembicara = str_replace(",Ph.", "|Ph.", $pembicara);
      $pembicara = str_replace(", Ph.", "| Ph.", $pembicara);
      $pembicara = explode(',', $narasumber);
      $pembicara = str_replace("|", ",", $pembicara);
      ?>

      <div class="container-fluid">
        <!-- PPT & Ringkasan -->
        <div class="row container-atas  _hidden">
          <div class="col-lg-6" style="padding:7px;">
            <?php
            if ($url_static) {
              ?>
              <?php
              $filename_with_slash = strrchr($url_static, '/');
              $filename = ltrim($filename_with_slash, '/');
              $new_filename = str_replace('.pdf', '.png', $filename);
              $image_url = $configPath . "img/" . $new_filename;
              
              if (file_exists("../img/".$new_filename)){
              ?>
                <div id="pdfViewer" style="display: none;">
                  <iframe src="<?php echo $url_static; ?>" width="100%" height="400px"></iframe>
                </div>
                <a href="#" onclick="togglePdfViewer();">
                  <img id="image" src="<?php echo $image_url; ?>" alt="Your Image Description" width="1280">
                </a>
                <div class="unduh">
                  <h6>Klik pada gambar untuk melihat presentasi dalam PDF</h6>
                </div>
              <?php
              }else{
                ?>
                <div id="pdfViewer">
                  <iframe src="<?php echo $url_static; ?>" width="100%" height="400px"></iframe>
                </div>
                <?php
              }
              ?>
              <?php
            } else {
              ?>
                <div class="error-message" style="padding:7px;">
                  <p class="text-center">Tampilan Presentasi belum tersedia, silahkan pergi ke <a
                      href="<?php echo $url_slideshare ?>" target="_blank">link ini</a></p>
                </div>
              <?php
            }
            ?>
          </div>
          <div class="col-lg-6" style>
            <div class="details-container">
              <div class="details-content">
                <h2>
                  <?php echo $judul; ?>
                </h2>

                <!-- Narasumer & Tanggal -->
                <div class="narsum-tanggal">
                  <p><span class="label"></span><span class="value" style="font-weight: bold;">
                      <?php echo $event; ?>
                  </p>
                  <?php
                  echo "Narasumber / Pembicara:   ";

                  $len_pembicara = count($pembicara);
                  for ($i = 0; $i < $len_pembicara; $i++) {
                    $item = $pembicara[$i];
                    $item = trim($item);
                    if ($item !== '') {
                      $link = 'javascript:void(0);'; // Set the link to javascript:void(0);
                      if ($i == ($len_pembicara-1)){
                        echo "<a href=\"$link\" class=\"narsum-link\" data-keyword=\"$item\"\">$item</a> ";
                      }else{
                        echo "<a href=\"$link\" class=\"narsum-link\" data-keyword=\"$item\"\">$item</a> " . ", ";
                      }
                    }
                  }
                  ?>
                  <p><span class="label"></span><span class="value"> Tanggal:
                      <?php echo date('j F Y', strtotime($tanggal)); ?>
                  </p>
                </div>

                <!-- Deskripsi Pendek -->
                <p><span class="label"></span>
                  <?php echo $deskripsi_pendek; ?>
                </p>

                <!-- Button YT & SlideShare -->
                <span>
                  <button type="button" class="btn-ln tonton">
                    <a href="<?php echo $url_youtube ?>" class="btn-ln-a" target="_blank">Youtube</a>
                  </button>
                  <?php
                  if ($url_slideshare) {
                    ?>
                    <button type="button" class="btn-ln">
                      <a href="<?php echo $url_slideshare ?>" class="btn-ln-a" target="_blank">Slideshare</a>
                    </button>
                    <?php
                  }
                  ?>
                   <?php
                  if ($url_static) {
                    ?>
                    <button type="button" class="btn-ln">
                      <a href="<?php echo $url_static ?>" class="btn-ln-a" target="_blank">Presentasi</a>
                    </button>
                    <?php
                  }
                  ?> 
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
              <h5 class="text-center">Pertanyaan Refleksi</h5>
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
              <!-- <h3>Materi Terkait</h3> -->
              <div id="related-results-container">
                
              </div>
            </section>
          </div>
        </div>

        <!-- Judul Terkait -->
        <div class="row materi-terkait judul-terkait">
          <div class="materi-text">
            <section class="_hidden">
              <!-- <h3>Judul Terkait</h3> -->
              <div id="related-judul-container"></div>
            </section>
          </div>
        </div>
      </div>


      <?php
    } else {
      ?>
      <br>
      <h1 style="color: white;">Document not found</h1><br>
          <?php
    }
  } else {
    ?>
      <br>
      <h1>Document not found</h1><br>
          <?php
  }
  ?>

</div>

          <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
          
          <?php
          include 'footer.php';
          ?>
<!-- </body>



</html> -->