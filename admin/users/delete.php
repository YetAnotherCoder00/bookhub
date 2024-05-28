<?php
include "../../server/mysqlInterface.php";

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true || (!isset($_GET["id"]) && $_GET["delete"] != 1)) {
	header("Location: ../index.php");
}

if (isset($_GET["id"])) {
	$id = intval($_GET["id"]);
}

if (isset($_GET["delete"])) {
	$query = sprintf("DELETE FROM kunden WHERE kid = %d", $id);
	$conn = connectToDb();
	$conn->query($query);
	header("Location: ./index.php");
}

?>

<h1>Are you sure you want to delete the account with the id: <?=$id?>?</h1>
<a href="./delete.php?id=<?=$id?>&delete=1">yes</a>
<a href="./index.php">no (take me back)</a>
