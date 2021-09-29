<?php

// API OpenWeatherMap
$apiKey = "4dc20a34e8efccbcf851eb7d6cf3288d";
$cityId = "2747596";
$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();

require_once "ccdatabase.php";


//Save the reservering to the database
$stmt = $db->prepare( "INSERT INTO `reserveringssysteem` (`naam`,`telefoonnummer`, `mail`, `datum`, `tijd`, `personen`, `opmerkingen`)
                  VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sisssis", $name, $telnr, $mail, $datum, $time, $personen, $opmerkingen);

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $name = mysqli_escape_string($db, $_POST['naam']);
    $telnr = mysqli_escape_string($db, $_POST['telefoonnummer']);
    $mail = mysqli_escape_string($db, $_POST['mail']);
    $datum = mysqli_escape_string($db, $_POST['datum']);
    $time = mysqli_escape_string($db, $_POST['tijd']);
    $personen = mysqli_escape_string($db, $_POST['personen']);
    $opmerkingen = mysqli_escape_string($db, $_POST['opmerkingen']);

    function getErrorsForFields($name, $telnr, $mail, $datum, $time, $personen, $opmerkingen) {
//Check if data is valid & generate error if not so
        $errors = [];
        if ($name == "") {
            $errors[] = 'Uw Naam cannot be empty';
        }
        if ($telnr == "") {
            $errors[] = 'Uw Telefoonnummer cannot be empty';
        }
        if ($mail == "") {
            $errors[] = ' Uw E-mail cannot be empty';
        }
        if ($datum == "") {
            $errors[] = 'dd-mm-jjjj cannot be empty';
        }
        if ($time == "") {
            $errors[] = 'Tijd cannot be empty';
        }
        if (!is_numeric($personen) || strlen($personen) != 1 || strlen($personen) != 2) {
            $errors[] = ' Aantal Personen needs to be a number with the length of 2';
        }
        if ($opmerkingen == "") {
            $errors[] = 'Opmerkingen cannot be empty';
        }
        return $errors;
    }
    $errors = getErrorsForFields($name, $telnr, $mail, $datum, $time, $personen, $opmerkingen);

    $hasErrors = !empty($errors);

    if (!$hasErrors) {
        insertIntoDatabase($name, $telnr, $mail, $datum, $time, $personen, $opmerkingen);
    }

    $stmt->execute();

    if ($stmt) {
        //
        echo"Reservering gelukt!";

        $subject = "Curry Corner Reservering";
        $body = "Beste $name,
                     uw reservering voor $personen personen op $datum, om $time is gelukt!
                     mvg,
                     Curry Corner";
        $headers = [
            'From' => 'senababacan@hotmail.com'
        ];
        //for($i=0;$i<50;$i++){
        if (mail($mail, $subject, $body, $headers)) {
            echo " Email successfully sent to $mail...";
        } else {
            echo " Email sending failed...";
        }
        //}

//            exit;
    } else {
        $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
    }

    mysqli_close($db);
}
?>

<!doctype html>
<html>

<head>
    <title> &copy; Curry Corner - Reserveringen</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="ccstyle.css"/>
</head>

<body>

<header>
    <nav>
        <div id="emptyspace"></div>
        <div class="navi"><a href="https://currycorner.nl/home">HOME</a></div>
        <div class="navi"><a href="https://currycorner.nl/home">ONLINE BESTELLEN</a></div>
        <div class="navi"><a href="ccindex.php">RESERVEREN</a></div>
        <div class="navi"><a href="https://currycorner.nl/contact">CONTACT</a></div>
        <div class="navi"><a href="cclogin.php">LOGIN</a></div>
    </nav>
</header>

<h2>Online Reserveren</h2>

<main>

<div class="center">
    <h1> ONLINE TAFEL RESERVEREN</h1>
    <p class="text">Reserveren? Vul uw gegevens in!</p>

    <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
        <div class="data-field">
            <label for="Uw Naam"></label>
            <input id="naam" type="text" placeholder="Uw Naam"  name="naam" value="<?= (isset($name) ? $name : ''); ?>" />
            <span><?= (isset($errors['Uw Naam']) ? $errors['Uw Naam'] : '') ?></span><br>
            <label for="Uw Telefoonnummer"></label>
            <input id="telefoonnummer" type="text" placeholder="Uw Telefoonnummer" name="telefoonnummer" value="<?= (isset($telnr) ? $telnr : ''); ?>" required/>
            <label for="Uw Email"></label><br>
            <input id="email" type="email" placeholder="Uw E-mail" name="mail" value="<?= (isset($mail) ? $mail : ''); ?>" required/>
        </div>

        <div class="data-field">
            <label for="dd-mm-jjjj"></label>
            <input id="dd-mm-jjjj" type="date" placeholder="Datum" name="datum" value="<?= (isset($datum) ? $datum : ''); ?>" required/><br>
            <label for="Tijd"></label>
            <input id="tijd" type="time" placeholder="Tijd" name="tijd" value="<?= (isset($time) ? $time : ''); ?>" /><br>
            <label for="Aantal Personen"></label>
            <input id="personen" type="number" placeholder="Aantal Personen" name="personen" value="<?= (isset($personen) ? $personen : ''); ?>" required/><br>
        </div>

        <div class="data-field">
            <label for="Opmerkingen"></label>
            <input id="opmerkingen" type="text" placeholder="Opmerkingen" name="opmerkingen" value="<?= (isset($opmerkingen) ? $opmerkingen : ''); ?>"/>
        </div>

        <div class="data-submit">
            <input type="submit" class="btn" name="submit" value="RESERVEER NU"/>
        </div>

    </form>
</div>

<div class="center">
    <h1>Curry Corner</h1>
        <p>
            <br>
        Lange Kerkstraat 27A
        <br>
        3111 NN Schiedam
        <br>
        010 761 73 42
        </p>
</div>

</main>

<footer>
    <div class="foot">
        <p class="title">CURRY CORNER</p><br>
        <p>
            Lange Kerkstraat 27A
            <br>
            3111 NN Schiedam
            <br>
            <br>
            010 761 73 42
            <br>
            <br>
            K.v.K. nr.: 75395584
            <br>
            BTW nr.: NL23329291088B01
        </p>
    </div>

    <div class="foot">
        <p class="title">INFORMATIE</p><br>
        <p>
            <a href="https://currycorner.nl/bestel-betaling">> Bestel & betaling</a>
            <br>
            <a href="https://currycorner.nl/privacy-policy">> Privacy policy</a>
            <br>
            <a href="https://currycorner.nl/algemene-voorwaarden">> Algemene voorwaarden</a>
            <br>
            <a href="https://currycorner.nl/overons">> Over ons</a>
        </p>
    </div>


    <div class="foot">
        <p class="title">BEZORGTIJDEN</p><br>
        <p>
            Maandag     17:00 - 22:00
            <br>
            Dinsdag     gesloten
            <br>
            Woensdag    17:00 - 22:00
            <br>
            Donderdag   17:00 - 22:00
            <br>
            Vrijdag     17:00 - 22:00
            <br>
            Zaterdag    17:00 - 22:00
            <br>
            Zondag      17:00 - 22:00
        </p>
    </div>

    <div class="foot">
        <p class="title">OPENINGSTIJDEN</p><br>
        <p>
            Maandag     16:00 - 22:00
            <br>
            Dinsdag     gesloten
            <br>
            Woensdag    16:00 - 22:00
            <br>
            Donderdag   16:00 - 22:00
            <br>
            Vrijdag     16:00 - 22:00
            <br>
            Zaterdag    16:00 - 22:00
            <br>
            Zondag      17:00 - 22:00
        </p>
    </div>

</footer>

</body>
</html>