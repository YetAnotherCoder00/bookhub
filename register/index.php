<?php

include "../server/mysqlInterface.php";

if (isset($_POST["submit"])) {
  if (!isset($_POST["username"], $_POST["password"], $_POST["name"], $_POST["vorname"])) {
    echo "try again, you have to input 4 things";
    die();
  }

  $username = htmlspecialchars(trim($_POST["username"]));
  $password = password_hash(htmlspecialchars(trim($_POST["password"])), PASSWORD_DEFAULT);
  $name = htmlspecialchars(trim($_POST["name"]));
  $vorname = htmlspecialchars(trim($_POST["vorname"]));

  if (strlen($username) > 45 || strlen($password) < 8) {
    echo "username has to be shorter than 45 characters and password longer than 8.";
    die();
  }

  $conn = connectToDb();

  $query = $conn->prepare("INSERT INTO benutzer (benutzername, passwort, name, vorname) VALUES (?, ?, ?, ?)");
  $query->bind_param("ssss", $username, $password, $name, $vorname);
  $query->execute();
  header("Location: ../login");
  die();
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
  <title>register</title>
</head>
<body>
  <form action="index.php" method="post">
    <input type="text" name="username" required="required" placeholder="username" maxlength="45">
    <input type="password" name="password" required="required" placeholder="password" minlength="8">
    <input type="text" name="name" required="required" placeholder="name" maxlength="100">
    <input type="text" name="vorname" required="required" placeholder="vorname" maxlength="100">
    admin?:
    <input type="checkbox" name="admin" value="1">
    <button type="submit" name="submit" value="flesh" >submit</button>
  </form>
</body>
</html>