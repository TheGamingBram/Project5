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

      if(mysqli_stmt_execute($stmt)){
        PHP_Allert("Succes, je bent aangemeld");// popup message to show that it worked
        header("Refresh:0; url=Klant_Page.php");// Refreshes page
      }else{
        PHP_Allert("Error, Probeer het later opnieuw!");
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
    <title>De Elstar</title>
    <link href="Assets/css/newcss.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./Assets/Img/2020_Packshot_Elstar_500x500px-300x300.png">
</head>
<body>
    <div class="container">
        <div class="input-container">
            <form name="klant_gegevens" method="post" autocomplete="off">
            <h1>Vul hier uw Gegevens In</h1> 
            <input type="text" name="name" class="question" required autocomplete="off"  />
            <label for="v_naam"><span>Naam</span></label>

            <input type="text" name="lastname" class="question" required autocomplete="off"  />
            <label for="a_naam"><span>Achternaam</span></label> 

            <input type="email" name="email" class="question" required autocomplete="off"  />
            <label for="email"><span>Email</span></label> 

            <input type="text" maxlength="6" minlength="6" name="postalcode" class="question" required autocomplete="off" />
            <label for="postcode"><span>Postcode</span></label> 

            <input type="number" name="housenr" class="question" required autocomplete="off"  />
            <label for="huisnummer"><span>HuisNummer</span></label> 

            <input type="submit" value="Submit!">
            </form>       
        </div>
    </div>
</body>
</html>