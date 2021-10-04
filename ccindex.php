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
            <input class="info" type="text" placeholder="Uw Naam"  name="naam" value="<?= (isset($name) ? $name : ''); ?>" />
            <span><?= (isset($errors['Uw Naam']) ? $errors['Uw Naam'] : '') ?></span><br>
            <label for="Uw Telefoonnummer"></label>
            <input class="info" type="text" placeholder="Uw Telefoonnummer" name="telefoonnummer" value="<?= (isset($telnr) ? $telnr : ''); ?>" required/>
            <label for="Uw Email"></label><br>
            <input class="info" type="email" placeholder="Uw E-mail" name="mail" value="<?= (isset($mail) ? $mail : ''); ?>" required/>
        </div>

        <div class="data-field">
            <label for="dd-mm-jjjj"></label>
            <input class="info" type="date" placeholder="Datum" name="datum" value="<?= (isset($datum) ? $datum : ''); ?>" required/><br>
            <label for="Tijd"></label>
            <input class="info" type="time" placeholder="Tijd" name="tijd" value="<?= (isset($time) ? $time : ''); ?>" /><br>
            <label for="Aantal Personen"></label>
            <input class="info" type="number" placeholder="Aantal Personen" name="personen" value="<?= (isset($personen) ? $personen : ''); ?>" required/><br>
        </div>

        <div class="data-field">
            <label for="Opmerkingen"></label>
            <input class="info" type="text" placeholder="Opmerkingen" name="opmerkingen" value="<?= (isset($opmerkingen) ? $opmerkingen : ''); ?>"/>
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