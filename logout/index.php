<?php
include "../server/mysqlInterface.php";

// unset session variables
unset($_SESSION["username"]);
unset($_SESSION["loggedIn"]);
unset($_SESSION["admin"]);

header("Location: ../index.php", true);
die();
