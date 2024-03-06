<?php
 if(isset($_POST['submit'])){
    if(isset($_POST['vname']) && strlen(trim($_POST['vname']))){
    echo "Vorname ist korrekt. <br>";
    }else{
        echo "Der Vorname ist nicht korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if(isset($_POST['nname']) && strlen(trim($_POST['nname']))){
        echo "Nachname ist korrekt. <br>";
        }else{
        echo "Der Nachname ist nciht korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if(isset($_POST['ort']) && strlen(trim($_POST['ort']))){
        echo "Wohnort ist korrekt. <br>";
        }else{
        echo "Der Wohnort ist nciht korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if(isset($_POST['0'])){
        echo "Die art des Wohnens ist korrekt. <br>";
        }else{
        echo "Die art des Wohnens ist korrekt. Bitte versuchen sie es erneut. <br>";
    }
    if(isset($_POST['sendung'])){
        echo "Es wurde eine Sendung ausgewählt. <br>";
        }else{
        echo "Es wurde keine Sendung ausgewählt. Bitte versuchen sie es erneut. <br>";
    }
 }
?>