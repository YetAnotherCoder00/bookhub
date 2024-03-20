<?php

include "server/mysqlInterface.php";
$pageNumber = $_GET["page"];
$sortBy = $_GET["sortBy"];
if (!isset($pageNumber)) {
    $pageNumber = 0; // first page
}
if (!isset($sortBy)) {
    $sortBy = "id";
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
?>
    <div>
        sortieren:
        <ul>
            <?php
            echo "<li><a href='/?page=" . $pageNumber . "'>clear</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=id'>id (default)</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=katalog'>katalog</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=nummer'>nummer</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=kurztitle'>kurztitle</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=kategorie'>kategorie</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=verkauft'>verkauft</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=kaufer'>kaufer</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=autor'>autor</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=title'>title</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=sprache'>sprache</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=foto'>foto</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=verfasser'>verfasser</a></li>";
            echo "<li><a href='/?page=" . $pageNumber  . "&sortBy=zustand'>zustand</a></li>";
            ?>
        </ul>
    </div>

    <div>
        test
    </div>
<?php
    $result = $conn->query("SELECT id, kurztitle FROM buecher ORDER BY " . $sortBy . " LIMIT " . $pageNumber * 18 . ", " . $booksPerPage);

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
            echo "<a href='?page=" . $i . "&sortBy=" . $sortBy . "'> " . ($i + 1) . " </a>";
        }

        ?>
    </div>

</body>

</html>
