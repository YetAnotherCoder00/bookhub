<?php

include "../server/mysqlInterface.php";

$conn = connectToDb();

$email = "";
$password = "";
if (isset($_POST["email"])) {
  $email = htmlspecialchars($_POST["email"]);
}
if (isset($_POST["password"])) {
  $password = htmlspecialchars($_POST["password"]);
}

echo password_hash($password, PASSWORD_DEFAULT);

$query = "SELECT email, password FROM benutzer";

$result = $conn->query($query);
foreach ($result->fetch_all() as $row) {
    $users[] = $row[0];
}

?>

<html lang="de">
    <head>
        <title>Admin Page</title>
        <link rel="stylesheet" href="../index.css">
    </head>

    <body>
        
      <?php include "../components/header.php" ?>
        
        <div class="login_content">
          <div class="login_panel">
            <div class="login_title">
              <h3>LogIn</h3>
            </div>
            <div class="login_form">
            <form method="POST" action="/login/index.php">
              <input class="mail" name="email" type="email" placeholder="E-Mail"><br>
              <input class="password" name="password" type="password" placeholder="Password"><br>
              <button type="submit">Submit the Flesh</button>
            </form>
            </div>
          </div>
        </div>

      <?php include "../components/footer.php" ?>

    </body>
</html>


