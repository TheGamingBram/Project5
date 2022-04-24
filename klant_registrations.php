<?php 
    include("./Assets/config.php"); //connection to database and some test functions
    include("./Assets/header.php"); //insert to bootstrap and other java scripts

    if(isset($_GET['delid'])){ // if the get is set to 'delid' then it will delete the id from the database
      $sql = "DELETE FROM `klant_gegevens` WHERE `klant_gegevens`.`id` = ?";
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
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $Update = mysqli_query($link, "UPDATE `klant_gegevens` SET `name` = '".$_POST['first_name']."', `lastname` = '".$_POST['last_name']."', `email` = '".$_POST['email']."', `postalcode` = '".$_POST['postalcode']."', `housenr` = '".$_POST['housenr']."' WHERE `klant_gegevens`.`id` = '".$_POST['id']."';");
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


                            $sql_statement = "SELECT * FROM `klant_gegevens`"; // simple sql to get all info from the "klant_gegevens" table
                            $result_sql_post = $con->query($sql_statement); // exceutes the sql

                            if($result_sql_post->num_rows>0){ //checks if there is data
                                while($row = $result_sql_post->fetch_assoc()){ //if there is data then you can use the data
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . " " . $row['lastname'] . "</td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-info btn-circle' data-bs-toggle='modal' data-bs-target='#Modal-".$row['id']."'><span class='fas fa-info' aria-hidden='true'></span></button>";
                                    echo "&nbsp;";
                                    echo "<button class='btn btn-warning btn-circle' data-bs-toggle='modal' data-bs-target='#Modal-edit-".$row['id']."'><span class='fas fa-pen' aria-hidden='true'></span></button>";
                                    echo "&nbsp;";
                                    echo "<a href='klant_registrations.php?delid=".$row['id']."'><button class='btn btn-danger btn-circle'><span class='fas fa-trash-can' aria-hidden='true'></span></button>";
                                    echo "</td>";
                                    echo "</tr>";

                                    $models .= "
                                    
                                    <div class='modal fade' id='Modal-edit-".$row['id']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                      <div class='modal-dialog modal-dialog-centered modal-lg'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title' id='exampleModalLabel'>Data aanpassen</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                          </div>
                                          <form method='post'>
                                          <div class='modal-body'>
                                          <input type='hidden' name='id' value='".$row['id']."'>
                                          <div class='mb-3'>
                                            <input type='text' class='form-control' name='first_name' value='".$row['name']."' required aria-describedby='first_name'>
                                            <div id='first_name' class='form-text'>Voornaam</div>
                                          </div>
                                          <div class='mb-3'>
                                            <input type='text' class='form-control' name='last_name' value='".$row['lastname']."' required aria-describedby='last_name'>
                                            <div id='last_name' class='form-text'>Achternaam</div>
                                          </div>
                                          <div class='mb-3'>
                                            <input type='email' class='form-control' name='email' value='".$row['email']."' required aria-describedby='email'>
                                            <div id='email' class='form-text'>Email</div>
                                          </div>
                                          <div class='mb-3'>
                                            <input type='text' maxlength='6' minlength='6' class='form-control' name='postalcode' value='".$row['postalcode']."' required aria-describedby='postalcode'>
                                            <div id='postalcode' class='form-text'>Post Code</div>
                                          </div>
                                          <div class='mb-3'>
                                            <input type='number' class='form-control' name='housenr' value='".$row['housenr']."' required aria-describedby='housenr'>
                                            <div id='housenr' class='form-text'>Huis nummer</div>
                                          </div>

                                          </div>
                                          <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-warning'>Aanpassen</button>
                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>

                                    ";

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
    $('#klant_tab').dataTable({ // creates the datatable
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/nl-NL.json" //adds dutch language support
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