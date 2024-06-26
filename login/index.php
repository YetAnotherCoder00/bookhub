<?php

$indexes = ["email" => 0, "password" => 1, "username" => 2, "admin" => 3];

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

//$query = sprintf("SELECT email, passwort, benutzername, admin FROM benutzer where benutzername LIKE \"%s\"", $username);
$query = $conn->prepare("SELECT email, passwort, benutzername, admin FROM benutzer WHERE benutzername LIKE ?");
$query->bind_param("s", $username);
$query->execute();

$result = $query->get_result();
foreach ($result->fetch_all() as $row) {
    if (password_verify($password, $row[$indexes["password"]])) {
        $_SESSION["username"] = $username;
        $_SESSION["loggedIn"] = true;

        if (isset($row[$indexes["admin"]]) && $row[$indexes["admin"]] == 1) {
            $_SESSION["admin"] = true;
        }
    }
}

if (isset($_SESSION["username"]) && isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
	header("Location: ../index.php");
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
          <div class="login_gradient_border">
            <div class="login_panel">
              <div class="login_title">
                <h3>LogIn</h3>
              </div>
              <div class="login_form">
              <form method="POST" action="./index.php">
                <div class="login_inputs">
                  <div>
                    <label for="mail">E-mail:</label>
                    <input id="mail" class="login_inputfield" name="username" type="text" placeholder="E-Mail"><br>
                  </div>
                  <div>
                    <label for="password">Password:</label>
                    <input id="password" class="login_inputfield" name="password" type="password" placeholder="Password">
                  </div> 
                </div>
                <div class="login_submit_container">
                  <button type="submit" class="login_button">Submit the Flesh</button>
                  <a href="../register" class="register_link">register</a>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>

      <?php include "../components/footer.php" ?>

    </body>
</html>


