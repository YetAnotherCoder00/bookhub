<?php
include "../server/mysqlInterface.php";

if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
	header("Location: ../index.php", true);
	die();
}

echo "welcome";
?>
<br>
You can create something here

<form action="create.php" method="post">
	<input type="text" name="username" placeholder="username">

</form>

<?php

?>
