<?php 
    include("./Assets/config.php");
    include("./Assets/header.php");
?>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">Fiets Verhuur De Elstar</a>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
          <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
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
                    <span class="fas fa-user"></span>
                    Merk Gegevens
                  </a>
                </li>
              </ul>
            </div>
          </nav>
      
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Merk Gegevens</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
              </div>
            </div>
            <div class="col-md-12">

            <div>
              <canvas id="myChart" width="600" height="100"></canvas>

              <?php 
              $names = "";
                  $sql_statement = "SELECT * FROM `merk_gegevens`";
                  $result_sql_post = $con->query($sql_statement);
                  if($result_sql_post->num_rows>0){
                    while($row = $result_sql_post->fetch_assoc()){
                      $names .= "'".$row['name']."',";
                    }
                }
              ?>
              <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [<?=$names?>],
                        datasets: [{
                            label: 'Aantal Fietsen Per Merk',
                            data: [],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
              </script>
            </div>
            
              <div style="margin-top: 10vh;">
                <table id="klant_tab" class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Merk Naam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_statement1 = "SELECT * FROM `merk_gegevens`";
                        $result_sql_post1 = $con->query($sql_statement1);
                            if($result_sql_post1->num_rows>0){
                                while($row1 = $result_sql_post1->fetch_assoc()){
                                  
                                  echo "<tr><td>".$row1['id']."</td>";
                                  echo "<td>".$row1['name']."</td></tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
              </div>
            </div>
          </main>
        </div>
      </div>
</body>
<script>
    $('#klant_tab').dataTable({
        responsive: true,
        "columnDefs": [
          {
              "targets": [0],
              "visible": false,
              "searchable": false
          }
        ]
    });
</script>