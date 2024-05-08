<?php

session_start();

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

$query = "SELECT email, passwort, benutzername FROM benutzer";

$result = $conn->query($query);
foreach ($result->fetch_all() as $row) {
    if (password_verify($password, $row[1])) {
        $_SESSION["username"] = $username;
        $_SESSION["loggedIn"] = true;
    }
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


