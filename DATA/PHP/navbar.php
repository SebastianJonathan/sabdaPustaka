<?php //include '../CONFIG/config.php' ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fix">
  <div class="container-fluid">
    <div class="row" style="width: 100%">
      <div class="col" style="width: 100px; left: 0;">
        <a class="navbar-brand navbar-brands" href="<?php echo $configPath?>PHP/home.php" style="padding-left:10px;">
          <img class="hoverable" src="<?php echo $configPath?>img/logo.png" alt="Logo Sabda">
        </a>
      </div>

      <div class="col">
        <form action="" id="search" class="content sect-search">
          <div class="rekomendasi-container">
            <div class="col-md-6 InputContainer" style="background-color: #1e0049; ">

              <input placeholder="Cari di SABDA Pustaka" id="query" class="query form-control form-input" name="query" type="text" autocomplete="off">

              <button type="button" class="search-button" onclick="goSearch()" style="background-color: #1e0049; color: white;">Cari</button>
            </div>

            <div id="rekomendasi">
              <ul id="rekomendasi-list"></ul>
            </div>
          </div>
        </form>
      </div>

      <div class="col" style="width: 300px; right: 0;"> 


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>



      </div>
    </div>
    <div class="row">

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link classB" href="<?php echo $configPath?>PHP/home.php">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link classB" href="<?php echo $configPath?>PHP/about.php">Tentang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link classB" href="<?php echo $configPath?>PHP/services.php">Layanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link classB" href="https://kontak.sabda.org/" target="_blank">Kontak</a>
              </li>
            </ul>
      </div>
    </div>




    <!-- <div class="container mt-5">
    <div class="input-group">
        <input type="text" class="form-control rounded-pill" placeholder="Search...">
        <button class="btn btn-primary rounded-pill" type="button">Search</button>
    </div>
</div> -->







  </div>
</nav>
<div style="height: 80px;"><!-- Spacer --></div> 