<?php
include "../../server/mysqlInterface.php";

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
	header("Location: ../index.php");
}

$kundenColumns = ["kid" => 0, "geburtstag" => 1, "vorname" => 2, "name" => 3, "geschlecht" => 4, "kunde_seit" => 5,
	"email" => 6, "kontaktpermail" => 7];

$conn = connectToDb();

$result = $conn->query("SELECT * FROM kunden");
?>
<html>
  <header>
    <link rel="stylesheet" href="../../index.css">
  </header>
  <body>
<?php
printf("<h1>Kunden: </h1>");
printf("<table>");
foreach ($result->fetch_all() as $row) {
	printf("<tr>");
	foreach ($row as $data) {
		printf("<td>" . $data . "</td>");
	}
	printf("<td> <a href='./update.php?id=%d'>update</a> </td>", $row[$kundenColumns["kid"]]);
	printf("<td> <a href='./delete.php?id=%d'>delete</a> </td>", $row[$kundenColumns["kid"]]);
	printf("</tr>");
}
printf("</table>");
?>
</body>
</html>
