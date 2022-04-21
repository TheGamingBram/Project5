<?php
// Establishes connection with the database 
include("./Assets/config.php");

// Back-End code for sending user input to database
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $sql = "INSERT INTO klant_gegevens (name, lastname, email, postalcode, housenr) VALUES (?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "sssss", $Vnaam, $Anaam, $Email, $Postcode, $Huisnummer);
        // Variables linked with form
        $Vnaam = ($_POST['name']);
        $Anaam = ($_POST['lastname']);
        $Email = ($_POST['email']);
        $Postcode = ($_POST['postalcode']);
        $Huisnummer = ($_POST['housenr']);

<<<<<<< HEAD
        // Messages to afirm the user what is happening with the data
        if(mysqli_stmt_execute($stmt)){
          PHP_Allert("Success");
        }else{
          PHP_Allert("Error, Probeer het later opnieuw!");
        }
      }
=======
      if(mysqli_stmt_execute($stmt)){
        header('Location: '.$_SERVER['PHP_SELF']);
      }else{
        PHP_Allert("Error, Probeer het later opnieuw!");
      }
    }else{
      PHP_Allert("Error, Probeer het later opnieuw!");
    }
>>>>>>> 9875917463212608f0958ba3c1b73f8307f0fbbd
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>De Elstar</title>
    <link href="Assets/css/newcss.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./Assets/Img/2020_Packshot_Elstar_500x500px-300x300.png">
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

            <input type="email" name="email" class="question" required autocomplete="off" />
            <label for="email"><span>Wat is uw Email?</span></label> 

            <input type="text" maxlength="6" minlength="6" name="postalcode" class="question" required autocomplete="off" />
            <label for="postcode"><span>Wat is uw Postcode?</span></label> 

            <input type="number" name="housenr" class="question" required autocomplete="off" />
            <label for="huisnummer"><span>Wat is uw HuisNummer?</span></label> 

            <input type="submit" value="Submit!">
            </form>       
        </div>
    </div>
</body>
</html>