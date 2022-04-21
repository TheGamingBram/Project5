<?php 
    include("./Assets/config.php");
    include("./Assets/header.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      if($_POST['type'] == "Insert"){
        $sql = "INSERT INTO fiets_gegevens (merk_id, model, gender, color, size, status, info) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
          mysqli_stmt_bind_param($stmt, "sssssss", $parm_merk, $parm_model, $parm_gender, $parm_color, $parm_size, $parm_status, $parm_info);
          $parm_merk = $_POST['merknr'];
          $parm_model = $_POST['ModelName'];
          $parm_gender = $_POST['geslachtfiets'];
          $parm_color = $_POST['kleur'];
          $parm_size = $_POST['size'];
          $parm_status = 0;
          $parm_info = $_POST['info_text'];
          if(mysqli_stmt_execute($stmt)){
            PHP_Allert("Success, je data is toegevoegdt");
            sleep(3);
            header('Location: '.$_SERVER['PHP_SELF']);
          }else{
            PHP_Allert("Error, Probeer het later opnieuw!");
          }
        }
      }else{

      }
    }
    
    $fill_select = "";
    $sql_statement = "SELECT * FROM `merk_gegevens`";
      $result_sql_post = $con->query($sql_statement);
      if($result_sql_post->num_rows>0){
        while($row = $result_sql_post->fetch_assoc()){
          $fill_select .= "<option value='".$row['id']."'>".$row['name']."</option>";
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
                                deelstar.merk_gegevens On deelstar.merk_gegevens.id = deelstar.fiets_gegevens.merk_id";
                            $result_sql_post = $con->query($sql_statement);

                            if($result_sql_post->num_rows>0){
                                while($row = $result_sql_post->fetch_assoc()){
                                    if($row['gender'] == 0){
                                      $gender = "Heren Fiets";
                                    }elseif($row['gender'] == 1){
                                      $gender = "Vrouwen Fiets";
                                    }else{
                                      $gender = "Gender neutrale Fiets";
                                    }

                                    if($row['status'] == 0){
                                      $status = "Beschikbaar";
                                    }elseif($row['status'] == 1){
                                      $status = "Verhuurd";
                                    }elseif ($row['status'] == 2) {
                                      $status = "Reparatie";
                                    }else{

                                    }


                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['model'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $gender . "</td>";
                                    echo "<td>" . $row['color'] . "</td>";
                                    echo "<td>" . $row['size'] . "</td>";
                                    echo "<td>" . $status . "</td>";
                                    echo "<td> </td>";
                                    echo "</tr>";
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
    $('#klant_tab').dataTable({
        responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/nl-NL.json"
        }
    });
</script>