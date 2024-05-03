<?php
// start session to get data
session_start();

// unset session variables
unset($_SESSION["username"]);
unset($_SESSION["loggedIn"]);

header("Location: ../index.php", true);
die();
