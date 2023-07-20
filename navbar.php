<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fix">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img class="hoverable" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%3Fid%3DOIP.-DIgo2WbCfM8jyCFP5qsFAAAAA%26pid%3DApi&f=1&ipt=f6d86badabdb6537163bb968301426ccc1565bab15485b2a38c1c92b96c30c39&ipo=images" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/UI/sabdaPustaka/home.php" onclick="deleteSessQuery()">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  function deleteSessQuery(){
    sessionStorage.removeItem("query")
    sessionStorage.removeItem("first")
  }
</script>