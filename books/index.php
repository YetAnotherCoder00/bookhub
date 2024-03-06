
<?php

$id = $_GET["id"];


// totally secure account management

require "../server/mysqlInterface.php";

$idIndex = 0;
$kurzTitleIndex = 3;
$descriptionIndex = 8;

$conn = connectToDb();

$result = $conn->query("SELECT * FROM buecher WHERE id = " . $id);
// print_r($result->fetch_all());

$bookInfo = $result->fetch_row();


?>


<html>

<head>

    <title><?= $bookInfo[$kurzTitleIndex]; ?></title>

</head>

<body>

    <?php
        echo $bookInfo[$descriptionIndex];
    ?>


</body>

</html>
