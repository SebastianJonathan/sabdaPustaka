<?php include '../API/config.php' ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fix">
  <div class="container">
    <a class="navbar-brand navbar-brands" href="https://live.sabda.org/">
      <img class="hoverable" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%3Fid%3DOIP.-DIgo2WbCfM8jyCFP5qsFAAAAA%26pid%3DApi&f=1&ipt=f6d86badabdb6537163bb968301426ccc1565bab15485b2a38c1c92b96c30c39&ipo=images" alt="Logo Sabda">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" onclick="home()" >Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="getAllList()" >List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="about()">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="services()">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="contact()">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div style="height: 60px;"><!-- Spacer --></div> 
<script>
  function home(){
    window.location.href = configPath + 'DATA/PHP/home.php';
  }
  function getAllList(){
    window.location.href = configPath + 'DATA/PHP/getAllList.php';
  }
  function about(){
    window.location.href = configPath + 'DATA/PHP/about.php';
  }
  function services(){
    window.location.href = configPath + 'DATA/PHP/services.php';
  }
  function contact(){
    window.location.href = configPath + 'DATA/PHP/contact.php';
  }
</script>