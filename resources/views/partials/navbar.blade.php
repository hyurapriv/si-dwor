<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container ">
      <a class="navbar-brand" href="#">DWOR</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link {{ ($judul  === "home") ? 'active' : ''}}" aria-current="page" href="/">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ ($judul  === "about") ? 'active' : ''}} " href="/about">CONSOLE BOX</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">PETUGAS PANGGIL</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">DISPLAY</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>