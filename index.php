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
<?php include "components/header.php"; ?>

    <div>
        test
    </div>

    <?php

    $idIndex = 0;
    $kurzTitleIndex = 1;

    $booksPerPage = 18;

    $conn = connectToDb();

    $result = $conn->query("SELECT id, kurztitle FROM buecher WHERE id > " . $pageNumber * 18 .
        " AND id <= " . ($pageNumber * 18 + $booksPerPage));
    echo $pageNumber . "<br>";
    echo $booksPerPage . "<br>";

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
