<?php

enum index: int {
  case email = 0;
  case password = 1;
  case username = 2;
}

include "../server/mysqlInterface.php";

$conn = connectToDb();

$username = "";
$password = "";
if (isset($_POST["username"])) {
  $username = htmlspecialchars($_POST["username"]);
}
if (isset($_POST["password"])) {
  $password = htmlspecialchars($_POST["password"]);
}

$query = sprintf("SELECT email, passwort, benutzername FROM benutzer where benutzername LIKE \"%s\"", $username);

$result = $conn->query($query);
foreach ($result->fetch_all() as $row) {
    if (password_verify($password, $row[index::password->value])) {
        $_SESSION["username"] = $username;
        $_SESSION["loggedIn"] = true;
    }
}

if (isset($_SESSION["username"]) && isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
	header("Location: ../index.php", true);
	die();
}

?>

<html lang="de">
    <head>
        <title>Admin Page</title>
        <link rel="stylesheet" href="../index.css">
    </head>

    <body>
        
      <?php include "../components/header.php" ?>
        
        <div class="content">
          <div class="login_panel">
            <div class="login_title">
              <h3>LogIn</h3>
            </div>
            <div class="login_form">
            <form method="POST" action="./index.php">
              <div>
                <input class="mail" name="username" type="text" placeholder="E-Mail"><br>
                <input class="password" name="password" type="password" placeholder="Password">
              </div>
              <button type="submit">Submit the Flesh</button>
            </form>
            </div>
          </div>
        </div>

      <?php include "../components/footer.php" ?>

    </body>
</html>


