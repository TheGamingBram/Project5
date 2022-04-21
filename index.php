<?php 
    include("./Assets/config.php");
    include("./Assets/header.php");

    $result = mysqli_query($link, "SELECT * FROM klant_gegevens;");
    $inschrijvingcount = mysqli_num_rows($result);

    $result_merk = mysqli_query($link, "SELECT * FROM merk_gegevens;");
    $Merkcount = mysqli_num_rows($result_merk);
?>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">Fiets Verhuur De Elstar</a>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
          <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="min-height: 100vh;">
            <div class="position-sticky pt-3">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="index.php">
                    <span class="fas fa-house-user"></span>
                    Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="klant_registrations.php">
                    <span class="fas fa-user"></span>
                    Klant Gegevens
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="merk_page.php">
                    <span class="fas fa-copyright"></span>
                    Merk Gegevens
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="Fiets_page.php">
                    <span class="fas fa-bicycle"></span>
                    Fiets Gegevens
                  </a>
                </li>
              </ul>
            </div>
          </nav>
      
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Dashboard</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
              </div>
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="card" style="width: 18rem; text-align: center;">
                  <br>
                  <i class="fas fa-user fa-5x"></i>
                  <div class="card-body">
                    <h5 class="card-title">Klant Informatie</h5>
                    <p class="card-text">Op Dit Moment hebben wij : <br> <?= $inschrijvingcount ?> Klanten.</p>
                    <a href="Klant_Page.php" class="btn btn-primary">Naar Registratie Pagina</a>
                    <a href="klant_registrations.php" class="btn btn-primary" style="margin-top: 1em;">Naar Klant Informatie Pagina</a>
                  </div>
                </div>
                <div class="card" style="width: 18rem; text-align: center; margin-left: 1em;">
                  <br>
                  <i class="fas fa-copyright fa-5x"></i>
                  <div class="card-body">
                    <h5 class="card-title">Merk Gegevens</h5>
                    <p class="card-text">Op Dit Moment hebben wij : <br> <?= $Merkcount ?> Merken.</p>
                    <a href="merk_page.php" class="btn btn-primary">Naar Merken Pagina</a>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
</body>