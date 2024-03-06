<?php

include "server/mysqlInterface.php";
$pageNumber = $_GET["page"];
if (!isset($pageNumber)) {
    $pageNumber = 0; // first page
}

?>

<html>

<head>
    <link href="index.css" rel="stylesheet">
    <title><?= "Index - Page " . ($pageNumber + 1) ?></title>
</head>

<body>

    <div>
        test
    </div>

    <?php

    $idIndex = 0;
    $kurzTitleIndex = 1;

    $booksPerPage = 18;

    $conn = connectToDb();

    $result = $conn->query("SELECT id, kurztitle FROM buecher WHERE ID > " . $pageNumber * 18 .
        " AND ID <= " . ($pageNumber * 18 + $booksPerPage));

    foreach ($result->fetch_all() as $value) {
        echo "<a href='/books?id=" . $value[$idIndex] . "'>" .
            $value[$idIndex] . ": " . $value[$kurzTitleIndex] . "
            </a>" . "<br> <br>";
    }

    ?>

    <div>
        <?php

        $result = $conn->query("SELECT COUNT(*) FROM buecher");
        $rowCount = $result->fetch_row();

        for ($i = 0; $i < ($rowCount[0] / $booksPerPage); $i++) {
            echo "<a href='?page=" . $i . "'> " . ($i + 1) . " </a>";
        }

        ?>
    </div>

</body>

</html>