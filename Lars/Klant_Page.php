<?php
include("../Assets/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["name"]))){
      PHP_Allert("vul AUB uw naam in");
    }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["name"]))){
      PHP_Allert("Deze tekens Gelden niet");
    }else{
      $sql = "INSERT INTO klant_gegevens (name, lastname, email, postalcode, housenr) VALUES (?. ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssss", $Vnaam, $Anaam, $Email, $Postcode, $Huisnummer);
            $Vnaam = ($_POST['name']);
            $Anaam = ($_POST['lastname']);
            $Email = ($_POST['email']);
            $Postcode = ($_POST['postalcode']);
            $Huisnummer = ($_POST['housenr']);

          if(mysqli_stmt_execute($stmt)){
            PHP_Allert("Success");
          }else{
            PHP_Allert("Error, Probeer het later opnieuw!");
          }
        }
      }

    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten_Page</title>
    <link href="newcss.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="input-container">
            <form name="klant_gegevens" method="post">
            <h1>Vul hier uw Gegevens In</h1> 
            <input type="text" name="name" class="question" required autocomplete="off" />
            <label for="v_naam"><span>Wat is uw Naam?</span></label>

            <input type="text" name="lastname" class="question" required autocomplete="off" />
            <label for="a_naam"><span>Wat is uw Achternaam?</span></label> 

            <input type="text" name="email" class="question" onchange="ValidateEmail()" required autocomplete="off"  />
            <label for="email"><span>Wat is uw Email?</span></label> 

            <input type="text" name="postalcode" class="question" required autocomplete="off" />
            <label for="postcode"><span>Wat is uw Postcode?</span></label> 

            <input type="text" name="housenr" class="question" required autocomplete="off" />
            <label for="huisnummer"><span>Wat is uw HuisNummer?</span></label> 

            <input type="submit" value="Submit!">
            </form>       
        </div>
    </div>
</body>
</html>