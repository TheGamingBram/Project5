<?php 
    include("./Assets/config.php"); //connection to database and some test functions
    include("./Assets/header.php"); //insert to bootstrap and other java scripts

    if(isset($_GET['delid'])){ // if the get is set to 'delid' then it will delete the id from the database
      $sql = "DELETE FROM `merk_gegevens` WHERE `merk_gegevens`.`id` = ?";
      if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $DelID); // prepaires the sql
        $DelID = $_GET['delid']; //sets the delid to delid
        if(mysqli_stmt_execute($stmt)){ //executes the sql
          header('Location: '.$_SERVER['PHP_SELF']); // reloads the page
        }else{
          PHP_Allert("Error, Probeer het later opnieuw!"); //error if it doesnt work
        }
      }
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){ //if the page is in post mode then it will start the insert code
      $sql = "INSERT INTO merk_gegevens (name) VALUES (?)"; //sql statement

      if($stmt = mysqli_prepare($link, $sql)){ //prepaires the sql statement
        mysqli_stmt_bind_param($stmt, "s", $param_name); // binds the parms
        $param_name = $_POST['MerkNaam']; //parm = to "mark naam"

        if(mysqli_stmt_execute($stmt)){ //excute the sql statement
          header('Location: '.$_SERVER['PHP_SELF']); // reloads the page
        }else{
          PHP_Allert("Error, Probeer het later opnieuw!"); //else errors out
        }
      }
    }
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
              <h1 class="h2">Merk Gegevens</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" data-bs-toggle="modal" class="btn btn-success" data-bs-target="#exampleModal">Merk Toevoegen</button>
              </div>
            </div>
            <div class="col-md-12">
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="post">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Merk Toevoegen</h5>
                      <button type="button" required class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <label for="MerkNaam" class="form-label">Merk Naam</label>
                      <input type="text" name="MerkNaam" id="MerkNaam" class="form-control">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                      <button type="submit" class="btn btn-success">Toevoegen</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                <div style="">
                  <table id="klant_tab" class="table">
                      <thead>
                          <tr>
                              <th>Id</th>
                              <th>Merk Naam</th>
                              <th>Acties</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          $sql_statement1 = "SELECT * FROM `merk_gegevens`"; // sql statement fro the "merk_gegevens"
                          $result_sql_post1 = $con->query($sql_statement1); //excecutes the statement
                              if($result_sql_post1->num_rows>0){ //checks if there is data
                                  while($row1 = $result_sql_post1->fetch_assoc()){ // sets up the results out of the sql
                                    
                                    echo "<tr><td>".$row1['id']."</td>";
                                    echo "<td>".$row1['name']."</td>";
                                    echo "<td><a href='merk_page.php?delid=".$row1['id']."'><button class='btn btn-danger btn-circle'><span class='fas fa-trash-can' aria-hidden='true'></span></button></td>";
                                    echo "</tr>";
                                  }
                              }
                          ?>
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
</body>
<script>
    $('#klant_tab').dataTable({ //sets up the datatables
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/nl-NL.json" // adds dutch language support
        },
        "columnDefs": [
          {
              "targets": [0],
              "visible": false,
              "searchable": false
          }
        ]
    });
</script>