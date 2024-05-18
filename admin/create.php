<?php
include "../server/mysqlInterface.php";

if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
	header("Location: ../index.php", true);
	die();
}

echo "welcome <br>";

if (isset($_POST["create"])) {
  if ($_POST["create"] == "user") {
    // handle user

    if (!isset($_POST["username"], $_POST["name"], $_POST["vornaame"], $_POST["password"], $_POST["email"])) {
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

create user!
<form action="create.php" method="post">
<!--  <input type="checkbox" hidden="hidden" checked="checked" name="creating" value="user">-->
	<input type="text" name="username" placeholder="username">
  <input type="text" name="name" placeholder="name">
  <input type="text" name="vorname" placeholder="vorname">
  <input type="text" name="password" placeholder="passwort">
  <input type="email" name="email" placeholder="email">
  <input type="checkbox" name="admin" placeholder="admin">
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

?>
