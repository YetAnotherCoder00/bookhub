<?php
include "../server/mysqlInterface.php";

if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
	header("Location: ../index.php", true);
	die();
}

echo "welcome";
?>
<br>
<a href="create.php">create</a>
<a href="list.php">list</a>
<a href="update.php">update</a>
<a href="delete.php">delete</a>
