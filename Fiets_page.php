<?php 
    include("./Assets/config.php"); //connection to database and some test functions
    include("./Assets/header.php"); //insert to bootstrap and other java scripts

    if(isset($_GET['delid'])){ // if the get is set to 'delid' then it will delete the id from the database
      $sql = "DELETE FROM `fiets_gegevens` WHERE `fiets_gegevens`.`id` = ?";
      if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $DelID); // prepaires the sql
        $DelID = $_GET['delid']; //sets the delid to delid
        if(mysqli_stmt_execute($stmt)){ //executes the sql
          //header('Location: '.$_SERVER['PHP_SELF']); // reloads the page
        }else{
          PHP_Allert("Error, Probeer het later opnieuw!"); //error if it doesnt work
        }
      }
    }
    if(isset($_GET['takebackid'])){
      $Update_verhuur_info = mysqli_query($link, "UPDATE `fiets_gegevens` SET `status` = '0' WHERE `fiets_gegevens`.`id` = '".$_GET['takebackid']."';"); //updates the status

      $Update_Verhuur_back = mysqli_query($link, "UPDATE `fiets_verhuur` SET `verhuur_deadline` = '".date('Y-m-d H:i:s')."' WHERE `fiets_verhuur`.`fiets_id` = '".$_GET['takebackid']."' ORDER BY id DESC LIMIT 1;"); //updates the pull back

      header('Location: '.$_SERVER['PHP_SELF']); // reloads the page
    }
    if(isset($_GET['Repairid'])){
      $Update_verhuur_info = mysqli_query($link, "UPDATE `fiets_gegevens` SET `status` = '0' WHERE `fiets_gegevens`.`id` = '".$_GET['Repairid']."';"); //updates the status
      header('Location: '.$_SERVER['PHP_SELF']); // reloads the page
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){ // if you get a post from the web page
      prettyprint($_POST);
      if($_POST['type'] == "Insert"){ // if there is an insert atribute then it goes in here
        $sql = "INSERT INTO fiets_gegevens (merk_id, model, gender, color, size, status, info) VALUES (?, ?, ?, ?, ?, ?, ?)"; // sql statement for the database
        if($stmt = mysqli_prepare($link, $sql)){ //prepaires the sql statement
          mysqli_stmt_bind_param($stmt, "sssssss", $parm_merk, $parm_model, $parm_gender, $parm_color, $parm_size, $parm_status, $parm_info); //binds the info for the sql statement
          // all info out of post
          $parm_merk = $_POST['merknr'];
          $parm_model = $_POST['ModelName'];
          $parm_gender = $_POST['geslachtfiets'];
          $parm_color = $_POST['kleur'];
          $parm_size = $_POST['size'];
          $parm_status = 0;
          $parm_info = $_POST['info_text'];
          // end post info
          if(mysqli_stmt_execute($stmt)){ //try's to excecute to the database
            PHP_Allert("Success, je data is toegevoegdt"); // popup message to show that it worked
          }else{
            PHP_Allert("Error, Probeer het later opnieuw!"); //if it fails then it shows this error
          }
        }
      }elseif($_POST['type'] == "Update"){
        $Update = mysqli_query($link, "UPDATE `fiets_gegevens` SET `model` = '".$_POST['ModelName']."', `gender` = '".$_POST['geslachtfiets']."', `color` = '".$_POST['kleur']."', `size` = '".$_POST['size']."', `info` = '".$_POST['info_text']."' WHERE `fiets_gegevens`.`id` = '".$_POST['id']."';");
      }elseif($_POST['type'] == "Verhuur"){
        if($_POST['klantid_verhuur'] != "0"){
          $Update_verhuur_info = mysqli_query($link, "UPDATE `fiets_gegevens` SET `status` = '1' WHERE `fiets_gegevens`.`id` = '".$_POST['id']."';");
          $sql = "INSERT INTO fiets_verhuur (klant_id, fiets_id) VALUES (?, ?)";
          if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $parm_Klant_ID, $parm_fiets_ID); //binds the info for the sql statement
            $parm_Klant_ID = $_POST['klantid_verhuur'];
            $parm_fiets_ID = $_POST['id'];
            if(mysqli_stmt_execute($stmt)){ //try's to excecute to the database
              PHP_Allert("Success, je data is toegevoegdt"); // popup message to show that it worked
            }else{
              PHP_Allert("Error, Probeer het later opnieuw! " . mysqli_stmt_error($stmt)); //if it fails then it shows this error
            }
          }
        }
        
      }elseif($_POST['type'] == "Repair"){
        $Update_verhuur_info = mysqli_query($link, "UPDATE `fiets_gegevens` SET `status` = '2' WHERE `fiets_gegevens`.`id` = '".$_POST['id']."';");
        $sql = "INSERT INTO fiets_reparaties (fiets_id, reparatie_datum, reparatie_info, reparatie_notities) VALUES (?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
          mysqli_stmt_bind_param($stmt, "ssss", $parm_fiets_id, $parm_datum, $parm_info, $parm_notes); //binds the info for the sql statement
          $parm_fiets_id = $_POST['id'];
          $parm_datum = date('Y-m-d H:i:s');
          $parm_info = $_POST['info_text'];
          $parm_notes = "";
          if(mysqli_stmt_execute($stmt)){ //try's to excecute to the database
            header('Location: '.$_SERVER['PHP_SELF']); // reloads the page
          }else{
            PHP_Allert("Error, Probeer het later opnieuw! " . mysqli_stmt_error($stmt)); //if it fails then it shows this error
          }
        }
      }else{
        
      }
    }
    
    $fill_select = "";
    $sql_statement = "SELECT * FROM `merk_gegevens`"; // statement to get all "merk" gegevens
      $result_sql_post = $con->query($sql_statement); // excecutes the sql statement
      if($result_sql_post->num_rows>0){ //checks if there is data
        while($row = $result_sql_post->fetch_assoc()){ //if there is data then you can use the data
          $fill_select .= "<option value='".$row['id']."'>".$row['name']."</option>"; //adds an option to the "fiets toevoegen" form
        }
      }
    
    $select_verhuur_users = "<option value='0'>-</option>";
    $sql_statement_users = "SELECT * FROM `klant_gegevens`"; // statement to get all "merk" gegevens
      $result_sql_users = $con->query($sql_statement_users); // excecutes the sql statement
      if($result_sql_users->num_rows>0){ //checks if there is data
        while($row_users = $result_sql_users->fetch_assoc()){ //if there is data then you can use the data
          $select_verhuur_users .= "<option value='".$row_users['id']."'>".$row_users['name']." ".$row_users['lastname']."</option>"; //adds an option to the "fiets toevoegen" form
        }
      }else{
        $select_verhuur_users = "<option value='0'>Geen Gebruikers Gevonden</option>";
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
              <h1 class="h2">Fiets Gegevens</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
              <button type="button" data-bs-toggle="modal" class="btn btn-success" data-bs-target="#exampleModal">Fiets Toevoegen</button>
              </div>
            </div>
            <div class="col-md-12">
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="post">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Fiets Toevoegen</h5>
                      <button type="button" required class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <input type="text" class="form-control" name="ModelName" required aria-describedby="ModelNaamHelp">
                        <div id="ModelNaamHelp" class="form-text">Model Naam</div>
                      </div>
                      <div class="mb-3">
                        <select class="form-select" name="merknr" aria-label="MerkNaamHelp">
                          <?=$fill_select?>
                        </select>
                        <div id="MerkNaamHelp" class="form-text">Merk</div>
                      </div>
                      <div class="mb-3">
                        <select class="form-select" name="geslachtfiets" aria-label="MerkNaamHelp">
                          <option value='0'>Heren Fiets</option>
                          <option value='1'>Vrouwen Fiets</option>
                          <option value='2'>Gender neutrale Fiets</option>
                        </select>
                        <div id="MerkNaamHelp" class="form-text">Geslacht Fiets</div>
                      </div>
                      <div class="mb-3">
                        <input type="text" class="form-control" name="kleur" required aria-describedby="colorHelp">
                        <div id="colorHelp" class="form-text">Kleur</div>
                      </div>
                      <div class="mb-3">
                        <input type="number" min="0" class="form-control" name="size" required aria-describedby="sizeHelp">
                        <div id="sizeHelp" class="form-text">Fiets Grote</div>
                      </div>
                      <div class="mb-3">
                      <textarea class="form-control" id="Texteara" name="info_text" rows="3"></textarea>
                        <div id="Texteara" class="form-text">Info Fiets</div>
                      </div>
                    </div>
                    <div class="modal-footer">
                       <input type="hidden" name="type" value="Insert">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                      <button type="submit" class="btn btn-success">Toevoegen</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            <div>
            <div class="col-md-12">
                <table id="klant_tab" class="table">
                    <thead>
                        <tr>
                            <th>Fiets Id</th>
                            <th>Fiets Naam</th>
                            <th>Merk Naam</th>
                            <th>Geslacht Fiets</th>
                            <th>Fiets Kleur</th>
                            <th>Fiets Grote</th>
                            <th>Fiets Status</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $models = "";


                            $sql_statement = "Select
                                deelstar.fiets_gegevens.id,
                                deelstar.merk_gegevens.name,
                                deelstar.fiets_gegevens.model,
                                deelstar.fiets_gegevens.gender,
                                deelstar.fiets_gegevens.color,
                                deelstar.fiets_gegevens.size,
                                deelstar.fiets_gegevens.status,
                                deelstar.fiets_gegevens.info
                            From
                                deelstar.fiets_gegevens Inner Join
                                deelstar.merk_gegevens On deelstar.merk_gegevens.id = deelstar.fiets_gegevens.merk_id"; //sql statement to get all info for the table
                            $result_sql_post = $con->query($sql_statement); // excecutes the sql statement

                            if($result_sql_post->num_rows>0){ // checks if there is data
                                while($row = $result_sql_post->fetch_assoc()){ // enables the data so it can be used
                                    if($row['gender'] == 0){ // if the data is 0 then it will be a "heren fiets"
                                      $gender = "Heren Fiets";
                                      $gender_select = "
                                        <option value='0' selected>Heren Fiets</option>
                                        <option value='1'>Vrouwen Fiets</option>
                                        <option value='2'>Gender neutrale Fiets</option>
                                      ";
                                    }elseif($row['gender'] == 1){ // if the data is 1 then it will be a "vrouwen fiets"
                                      $gender = "Vrouwen Fiets";
                                      $gender_select = "
                                        <option value='0'>Heren Fiets</option>
                                        <option value='1' selected>Vrouwen Fiets</option>
                                        <option value='2'>Gender neutrale Fiets</option>
                                      ";
                                    }else{ //else there it will be a "Gender neutrale Fiets"
                                      $gender = "Gender neutrale Fiets";
                                      $gender_select = "
                                        <option value='0'>Heren Fiets</option>
                                        <option value='1'>Vrouwen Fiets</option>
                                        <option value='2' selected>Gender neutrale Fiets</option>
                                      ";
                                    }

                                    if($row['status'] == 0){ // if the data is 0 then it will be a "Beschikbaar"
                                      $status = "Beschikbaar";
                                    }elseif($row['status'] == 1){ // if the data is 0 then it will be a "Verhuurd"
                                      $status = "Verhuurd";
                                    }elseif ($row['status'] == 2) { // if the data is 0 then it will be a "Reparatie"
                                      $status = "Reparatie";
                                    }else{ // else the data will be empty
                                      $status = "";
                                    }


                                    echo "<tr>"; // prepares the data for datatables
                                    echo "<td>" . $row['id'] . "</td>";

                                    if($row['info'] != ""){
                                      echo "<td> <a href='#' class='text-black' data-bs-toggle='tooltip' data-bs-original-title='" . $row['info'] . "'>" . $row['model'] . "</a></td>";
                                    }else{
                                      echo "<td> " . $row['model'] . "</td>";
                                    }
                                    
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $gender . "</td>";
                                    echo "<td>" . $row['color'] . "</td>";
                                    echo "<td>" . $row['size'] . "</td>";

                                    if($row['status'] == 1 ){

                                      $verhuurSQL = " Select deelstar.klant_gegevens.name, deelstar.klant_gegevens.lastname 
                                      From
                                          deelstar.fiets_verhuur Inner Join
                                          deelstar.klant_gegevens On deelstar.klant_gegevens.id = deelstar.fiets_verhuur.klant_id Inner Join
                                          deelstar.fiets_gegevens On deelstar.fiets_gegevens.id = deelstar.fiets_verhuur.fiets_id
                                      WHERE deelstar.fiets_gegevens.id = ".$row['id']."
                                      ORDER BY deelstar.fiets_verhuur.id DESC
                                      LIMIT 1";
                                      $verhuurSQL_Result = $con->query($verhuurSQL);
                                      while($row_verhuur =  $verhuurSQL_Result->fetch_assoc()){
                                        echo "<td> <a href='#' class='text-black' data-bs-toggle='tooltip' data-bs-original-title='Verhuurd aan : ".$row_verhuur['name']." ".$row_verhuur['lastname']."'>" . $status . "</a></td>";
                                      }
                                    }elseif ($row['status'] == 2) {

                                      $ReparatieSQL = " Select reparatie_info
                                      From
                                        fiets_reparaties
                                      WHERE fiets_id = ".$row['id']."
                                      ORDER BY id DESC
                                      LIMIT 1";
                                      $ReparatieSQL_Result = $con->query($ReparatieSQL);
                                      while($row_Reparatie =  $ReparatieSQL_Result->fetch_assoc()){
                                        echo "<td> <a href='#' class='text-black' data-bs-toggle='tooltip' data-bs-original-title='In reparatie voor : ".$row_Reparatie['reparatie_info']."'>" . $status . "</a></td>";
                                      }

                                    }
                                    else{
                                      echo "<td>" . $status . "</td>";
                                    }
                                    echo "<td>" ;

                                    if($row['status'] == 0){
                                      echo '

                                      <div class="modal fade" id="Modal-verhuur-'.$row['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <form method="post">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Fiets Verhuren</h5>
                                              <button type="button" required class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="mb-3">
                                                <select class="form-select" name="klantid_verhuur" aria-label="klantid_verhuur">
                                                  '.$select_verhuur_users.'
                                                </select>
                                                <div id="klantid_verhuur" class="form-text">Verhuren aan</div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <input type="hidden" name="type" value="Verhuur">
                                              <input type="hidden" name="id" value="'.$row['id'].'">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                                              <button type="submit" class="btn btn-success">Toevoegen</button>
                                            </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      
                                      ';

                                      echo '

                                      <div class="modal fade" id="Modal-repair-'.$row['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <form method="post">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Fiets Reparatie</h5>
                                              <button type="button" required class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="mb-3">
                                              <textarea class="form-control" id="Texteara" name="info_text" rows="3">'. $row['info'] .'</textarea>
                                                <div id="Texteara" class="form-text">Info Reparaite</div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <input type="hidden" name="type" value="Repair">
                                              <input type="hidden" name="id" value="'.$row['id'].'">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                                              <button type="submit" class="btn btn-success">Reparatie Toevoegen</button>
                                            </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      
                                      ';

                                      echo "<button class='btn btn-success btn-circle' data-bs-toggle='modal' data-bs-target='#Modal-verhuur-".$row['id']."'><span class='fas fa-share' aria-hidden='true'></span></button>";
                                      echo "&nbsp;";
                                      echo "<button class='btn btn-success btn-warning' data-bs-toggle='modal' data-bs-target='#Modal-repair-".$row['id']."'><span class='fas fa-wrench' aria-hidden='true'></span></button>";
                                      echo "&nbsp;";
                                      
                                      


                                    }elseif ($row['status'] == 1) {
                                      echo "<a href='?takebackid=".$row['id']."'><button class='btn btn-success btn-circle'><span class='fas fa-share' aria-hidden='true'></span></button></a>";
                                      echo "&nbsp;";
                                    }else{
                                      echo "<a href='?Repairid=".$row['id']."'><button class='btn btn-success btn-circle'><span class='fas fa-wrench' aria-hidden='true'></span></button></a>";
                                      echo "&nbsp;";
                                    }

                                    echo "<button class='btn btn-warning btn-circle' data-bs-toggle='modal' data-bs-target='#Modal-edit-".$row['id']."'><span class='fas fa-pen' aria-hidden='true'></span></button>";
                                    echo "&nbsp;";
                                    echo "<a href='Fiets_page.php?delid=".$row['id']."'><button class='btn btn-danger btn-circle'><span class='fas fa-trash-can' aria-hidden='true'></span></button></a>";
                                    echo "</td>";
                                    echo "</tr>";


                                    echo '
                                    
                                    <div class="modal fade" id="Modal-edit-'.$row['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <form method="post">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Fiets Aanpassen</h5>
                                            <button type="button" required class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="mb-3">
                                              <input type="text" class="form-control" name="ModelName" value="'. $row['model'].'" required aria-describedby="ModelNaamHelp">
                                              <div id="ModelNaamHelp" class="form-text">Model Naam</div>
                                            </div>
                                            <div class="mb-3">
                                              <select class="form-select" name="geslachtfiets" aria-label="MerkNaamHelp">
                                                '.$gender_select.'
                                              </select>
                                              <div id="MerkNaamHelp" class="form-text">Geslacht Fiets</div>
                                            </div>
                                            <div class="mb-3">
                                              <input type="text" value="'.$row['color'].'" class="form-control" name="kleur" required aria-describedby="colorHelp">
                                              <div id="colorHelp" class="form-text">Kleur</div>
                                            </div>
                                            <div class="mb-3">
                                              <input type="number" value="' . $row['size'] . '" min="0" class="form-control" name="size" required aria-describedby="sizeHelp">
                                              <div id="sizeHelp" class="form-text">Fiets Grote</div>
                                            </div>
                                            <div class="mb-3">
                                            <textarea class="form-control" id="Texteara" name="info_text" rows="3">'. $row['info'] .'</textarea>
                                              <div id="Texteara" class="form-text">Info Fiets</div>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <input type="hidden" name="type" value="Update">
                                            <input type="hidden" name="id" value="'.$row['id'].'">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                                            <button type="submit" class="btn btn-success">Toevoegen</button>
                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>

                                    ';

                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
          </main>
        </div>
      </div>
</body>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')) //enables a tooltip for the bike info
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
    $('#klant_tab').dataTable({ //creates the datatable
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/nl-NL.json" //add the dutch language support
        }
    });
</script>