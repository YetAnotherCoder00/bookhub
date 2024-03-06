<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
<h1>Bitte füllen Sie das Formular komplett aus</h1>

<form action="index.php" method="post">
    <h2>Persönliche Daten</h2>
    <label for="vorname">Vorname:</label>
    <input type="text" name="vname" id="vname"> <br> <br>

    <label for="nachname">Nachname:</label>
    <input type="text" name="nname" id="nname"> <br> <br>

    <label for="ort">Wohnort:</label>
    <input type="text" name="ort" id="wohnort"> <br> <br>

    <h2>Was wir wissen wollen</h2>
    <label for="0">Wie wohnen Sie?</label>

    <input type="radio" name="0" id="1"> Einfamilienhaus

    <input type="radio" name="0" id="2"> Eigentumswohnung

    <input type="radio" name="0" id="3"> Mehrfamilienhaus
    <br><br>

    <label for="sendung">Welche TV-Sendungen sehen Sie gerne?</label>

    <input type="checkbox" name="sendung" id="a"> Dokumentation

    <input type="checkbox" name="sendung" id="b"> Nachrichten

    <input type="checkbox" name="sendung" id="c"> Spielfilme

    <input type="checkbox" name="sendung" id="d"> Sport
    <br><br>

    <label for="kommentar">Haben Sie noch eine Nachricht für uns?</label>
    <textarea name="kommentar" id="kommentar" cols="35" rows="5"></textarea>
    <br><br>

    <input type="submit" name="submit" value="Daten speichern">
    <input type="reset" value="Zurücksetzen">
</form>

</body>
</html>

<?php


if (isset($_POST['submit'])) {
    if (isset($_POST['vname']) && strlen(trim($_POST['vname']))) {
        echo "Vorname ist korrekt. <br>";
    } else {
        echo "Der Vorname ist nicht korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if (isset($_POST['nname']) && strlen(trim($_POST['nname']))) {
        echo "Nachname ist korrekt. <br>";
    } else {
        echo "Der Nachname ist nciht korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if (isset($_POST['ort']) && strlen(trim($_POST['ort']))) {
        echo "Wohnort ist korrekt. <br>";
    } else {
        echo "Der Wohnort ist nicht korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if (isset($_POST['0'])) {
        echo "Die Art des Wohnens ist korrekt. <br>";
    } else {
        echo "Die Art des Wohnens ist korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if (isset($_POST['sendung'])) {
        echo "Es wurde eine Sendung ausgewählt. <br>";
    } else {
        echo "Es wurde keine Sendung ausgewählt. Bitte versuchen sie es erneut. <br>";
    }
}


?>