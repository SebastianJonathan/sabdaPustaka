<?php //include '../CONFIG/config.php' ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fix">
  <div class="container-fluid">
    <a class="navbar-brand navbar-brands" href="http://dev.sabda.its/sabdapustaka/PHP/home.php" style="padding-left:10px;">
      <img class="hoverable" src="<?php echo $configPath?>img/logo.png" alt="Logo Sabda">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
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
          <a class="nav-link classB" href="<?php echo $configPath?>PHP/contact.php">Kontak</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div style="height: 56px;"><!-- Spacer --></div> 
<!-- <script>
  function home(){
    window.location.href = configPath + 'PHP/home.php';
  }
  function getAllList(){
    window.location.href = configPath + 'PHP/getAllList.php';
  }
  function about(){
    window.location.href = configPath + 'PHP/about.php';
  }
  function services(){
    window.location.href = configPath + 'PHP/services.php';
  }
  function contact(){
    window.location.href = 'https://s.id/medsosYLSA';
  }
</script> -->