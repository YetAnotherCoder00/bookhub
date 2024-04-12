<?php

include "../server/mysqlInterface.php";

$sortByColumns = ["id", "kurztitle", "autor"];


$pageNumber = $_GET["page"] ?? 0;
$sortBy = $_GET["sortBy"] ?? "id";
$search = $_GET["search"] ?? "";



?>

<html>
<head>

</head>

<body>

<div class="advancedsearch">
    <form action="/search/index.php" method="get" class="advancedsearch_form">
        <select name="sortBy" onchange="this.form.submit()">
            <option value="" disabled selected>Sort by <i class="fa-solid fa-chevron-down"></i></option>
            <?php
            foreach ($sortByColumns as $sortByColumn) {
                $value = sprintf("%s&search=%s", $sortByColumn, $search);
                echo sprintf("<option value=\"%s\">%s</option>", $value, $sortByColumn);
            }
            ?>
        </select>
    </form>
    <button class="activateFilters">Filters</button>
    <form action="/search/index.php" method="get" class="advancedsearch_form">
        <select name="sortBy" onchange="this.form.submit()">
            <option value="" disabled selected>Sort by <i class="fa-solid fa-chevron-down"></i></option>
            <?php
            foreach ($sortByColumns as $sortByColumn) {
                echo "<option value=" . $sortByColumn . ">" . $sortByColumn . "</option>";
            }
            ?>
        </select>
    </form>
    <?php

    $idIndex = 0;
    $kurzTitleIndex = 1;

    $booksPerPage = 18;

    $conn = connectToDb();
    ?>

    <div>
        test
    </div>
    <div class="mainDiv">
        <?php
        $query = sprintf("SELECT id, kurztitle FROM book.buecher 
        WHERE kurztitle LIKE '%%%s%%' ORDER BY %s 
        LIMIT %d, %d", $search, $sortBy, $pageNumber, $booksPerPage);
        $result = $conn->query($query);

        foreach ($result->fetch_all() as $value) {
            echo "<div class='bookDiv'>";
            echo "<a href='/books?id=" . $value[$idIndex] . "'>" .
                $value[$idIndex] . ": " . $value[$kurzTitleIndex] . "
                </a>" . "<br> <br>";
            echo "</div>";
        }

        ?>
    </div>

    <div>
        <?php
        $countQuery = sprintf("SELECT COUNT(*) FROM book.buecher 
        WHERE kurztitle LIKE '%%%s%%' ORDER BY %s 
        LIMIT %d, %d", $search, $sortBy, $pageNumber, $booksPerPage);
        $result = $conn->query($countQuery);
        $rowCount = $result->fetch_row();

        for ($i = 0; $i < ($rowCount[0] / $booksPerPage); $i++) {
            echo "<a href='?page=" . $i . "&sortBy=" . $sortBy . "'> " . ($i + 1) . " </a>";
        }

        ?>
    </div>
</div>
</body>
</html>
