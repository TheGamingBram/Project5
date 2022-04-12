<?php 
        include("../Assets/config.php");
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
            <form action="" method="POST">
            <h1>Vul hier uw Gegevens In</h1> 
            <input type="text" name="v_naam" class="question" required autocomplete="off" />
            <label for="v_naam"><span>Wat is uw Naam?</span></label>

            <input type="text" name="a_naam" class="question" required autocomplete="off" />
            <label for="a_naam"><span>Wat is uw Achternaam?</span></label> 

            <input type="text" name="email" class="question" required autocomplete="off" />
            <label for="email"><span>Wat is uw Email?</span></label> 

            <input type="text" name="postcode" class="question" required autocomplete="off" />
            <label for="postcode"><span>Wat is uw Postcode?</span></label> 

            <input type="text" name="huisnummer" class="question" required autocomplete="off" />
            <label for="huisnummer"><span>Wat is uw HuisNummer?</span></label> 

            <input type="submit" value="Submit!">
            </form>       
        </div>
    </div>
</body>
</html>