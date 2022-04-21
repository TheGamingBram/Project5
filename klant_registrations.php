<?php 
    include("./Assets/config.php");
    include("./Assets/header.php");

    if(isset($_GET['delid'])){
      $sql = "DELETE FROM `klant_gegevens` WHERE `klant_gegevens`.`id` = ?";
      if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $DelID);
        $DelID = $_GET['delid'];
        if(mysqli_stmt_execute($stmt)){
          header('Location: '.$_SERVER['PHP_SELF']);
        }else{
          PHP_Allert("Error, Probeer het later opnieuw!");
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
              <h1 class="h2">Klant Gegevens</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
              </div>
            </div>
            <div class="col-md-12">
                <table id="klant_tab" class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Klant Naam</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $models = "";


                            $sql_statement = "SELECT * FROM `klant_gegevens`";
                            $result_sql_post = $con->query($sql_statement);

                            if($result_sql_post->num_rows>0){
                                while($row = $result_sql_post->fetch_assoc()){
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . " " . $row['lastname'] . "</td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-info btn-circle' data-bs-toggle='modal' data-bs-target='#Modal-".$row['id']."'><span class='fas fa-info' aria-hidden='true'></span></button>";
                                    echo "  ";
                                    echo "<a href='klant_registrations.php?delid=".$row['id']."'><button class='btn btn-danger btn-circle'><span class='fas fa-trash-can' aria-hidden='true'></span></button>";
                                    echo "</td>";
                                    echo "</tr>";

                                    $models .= "
                                    
                                    <div class='modal fade' id='Modal-".$row['id']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                      <div class='modal-dialog modal-dialog-centered modal-lg'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title' id='exampleModalLabel'>" . $row['name'] . " " . $row['lastname'] . "</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                          </div>
                                          <div class='modal-body'>
                                            <table class='table'>
                                              <thead>
                                                <th scope='col'>Klant ID</th>
                                                <th scope='col'>Naam</th>
                                                <th scope='col'>Email</th>
                                                <th scope='col'>Postcode</th>
                                                <th scope='col'>Huisnummer</th>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <th scope='row'>".$row['id']."</th>
                                                  <td>" . $row['name'] . " " . $row['lastname'] . "</td>
                                                  <td>".$row['email']."</td>
                                                  <td>".$row['postalcode']."</td>
                                                  <td>".$row['housenr']."</td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    ";

                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
          </main>
          <?= $models ?>
        </div>
      </div>
</body>
<script>
    $('#klant_tab').dataTable({
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/nl-NL.json"
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