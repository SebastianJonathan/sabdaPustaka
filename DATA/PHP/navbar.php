<?php //include '../CONFIG/config.php' ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fix" id="navbar">
  <div class="container-fluid">
    <div class="row" style="width: 100%">
    
      <div class="col col-md-2 col-lg-2 col-sm-3" style="min-width: 100px; left: 0;" id="logo">
        <a class="navbar-brand navbar-brands" href="<?php echo $configPath?>PHP/home.php" style="padding-left:10px;">
          <img class="hoverable" src="<?php echo $configPath?>img/logo.png" alt="Logo Sabda">
        </a>
      </div>
      <button class="back-search-btn" id="back-search-icon" style="width: fit-content;" type="button" onclick="toogleNavbar()">
              <img style="width: 28px;" src="<?php echo $configPath?>img\aback.png" alt="Back">
      </button>

      <div class="col ">
        <form action="" id="search" class="content sect-search ">


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

      <div class="col col-lg-2 col-md-2 col-sm-3 tog-nav" id="togNav" style="min-width: 100px; right: 0;"> 


        <button class="nav-search-btn" id="search-icon" style="padding-right:13px;" type="button" onclick="toogleNavbar()">
          <img style="width: 28px;" src="<?php echo $configPath?>img\search-symbol.png" alt="Search">
        </button>

        <button class="navbar-toggler" id="toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="height: 40px;">
          <span class="navbar-toggler-icon"></span>
        </button>


      </div>


      </div>
    </div>


    <div>
      <div class="collapse navbar-collapse justify-content-end" style="padding-left: 20px;" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link classB" href="<?php echo $configPath?>PHP/home.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link classB" href="<?php echo $configPath?>PHP/about.php">Tentang</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link classB" href="<?php //echo $configPath?>PHP/services.php">Layanan</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link classB" href="https://kontak.sabda.org/" target="_blank">Kontak</a>
          </li>
        </ul>
      </div>

    </div>
</nav>
<div style="height: 60px;" id="navbar-sp"><!-- Spacer --></div> 