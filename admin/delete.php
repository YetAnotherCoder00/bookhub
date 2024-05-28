<?php
include "../server/mysqlInterface.php";

$conn = connectToDb();

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true || (isset($_GET["delete"]) && $_GET["delete"] === "0")) {
    header("Location: ../search");
    die();
}

if (isset($_GET["delete"]) && $_GET["delete"] === "1") {
    $conn->query("DELETE FROM buecher WHERE id = " . $_GET["id"]);
    header("Location: ../search");
    die();
}

?>

<h1>
    Are you sure you want to delete this book?
</h1>
<a href="./delete.php?id=<?= $_GET["id"] ?>&delete=1">yes</a>
<a href="./delete.php?id=<?= $_GET["id"] ?>&delete=0">no</a>