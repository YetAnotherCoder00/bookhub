<?php
include "../server/mysqlInterface.php";

if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
	header("Location: ../index.php", true);
	die();
}

$conn = connectToDb();

echo "welcome <br>";

if (isset($_POST["create"])) {
  if ($_POST["create"] == "user") {
    // handle user

    if (isset($_POST["name"], $_POST["vorname"], $_POST["password"], $_POST["email"], $_POST["geburtstag"],
      $_POST["geschlecht"])) {
      echo "set enough";
			$name = htmlspecialchars(trim($_POST["name"]));
			$vorname = htmlspecialchars(trim($_POST["vorname"]));
			$email = htmlspecialchars(trim($_POST["email"]));
			$geburtstag = htmlspecialchars(trim($_POST["geburtstag"]));
      $kontaktperemail = isset($_POST["kontaktperemail"]);
      $geschlect = $_POST["geschlecht"];
      $currentDate = date("Y-m-d");

      // kid doesn't have a default / automatic value, so here is a messy workaround
      $result = $conn->query("SELECT * FROM kunden ORDER BY kid DESC LIMIT 1");
      $kid = $result->fetch_row()[0] + 1;

      // yes, everything *needs* to be filled out, nothing has a default / automatic value
      $preparedQuery = $conn->prepare("INSERT INTO kunden (
        kid, name, vorname, email, geburtstag, kontaktpermail, kunde_seit, geschlecht) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $preparedQuery->bind_param("issssiss", $kid, $name, $vorname, $email, $geburtstag,
        $kontaktperemail, $currentDate, $geschlect);
      $preparedQuery->execute();
    }
    else {
      echo "not set enough";
    }
  }
  else if ($_POST["create"] == "book") {
    // handle book
  }
}
?>
<br>
You can create something here

create customer!
<form action="create.php" method="post">
<!--  <input type="checkbox" hidden="hidden" checked="checked" name="creating" value="user">-->
  <input type="text" name="name" placeholder="name" required="required">
  <input type="text" name="vorname" placeholder="vorname" required="required">
  <input type="password" name="password" placeholder="password" required="required">
  <input type="email" name="email" placeholder="email" required="required">
  <input type="date" name="geburtstag" placeholder="geburtstag" required="required">
  M:
  <input type="radio" name="geschlecht" value="M">
  F:
  <input type="radio" name="geschlecht" value="F">
  kontakt per email:
  <input type="checkbox" name="kontaktperemail" placeholder="kontaktperemail">
  <button type="submit" name="create" value="user">submit the flesh of the user</button>
</form>


create book!
<form action="create.php" method="post">
<!--  <input type="checkbox" hidden="hidden" checked="checked" value="book">-->
  <input type="number" name="katalog" placeholder="katalog">
  <input type="number" name="nummer" placeholder="nummer">
  <input type="text" name="kurztitle" placeholder="kurztitle">
  <input type="number" name="kategorie" placeholder="kategorie">
  <input type="checkbox" name="verkauft" placeholder="verkauft">
  <input type="number" name="kaufer" placeholder="kaufer">
  <input type="text" name="autor" placeholder="autor">
  <input type="text" name="title" placeholder="title">
  <input type="file" name="foto" placeholder="foto">
  <input type="number" name="verfasser" placeholder="verfasser">
  <input type="text" name="zustand" placeholder="zustand">
  <input type="number" name="price" placeholder="price">

  <button type="submit" name="create" value="book">submit the fleshy nature of the book</button>
</form>

<?php

if (isset($_POST["create"])){
  echo $_POST["create"];
}

?>
