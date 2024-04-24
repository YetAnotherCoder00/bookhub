<?php

include "../server/mysqlInterface.php";

$sortByColumns = ["id", "kurztitle", "autor"];

$filterColumns = ["kategorie", "verkauft", "zustand"];

if (isset($_GET["page"])) {
    $pageNumber = htmlspecialchars($_GET["page"]);
}
else {
    $pageNumber = 0;
}

if (isset($_GET["sortBy"])) {
    $sortBy = htmlspecialchars($_GET["sortBy"]);
}
else {
    $sortBy = "id";
}

if (isset($_GET["search"])) {
    $search = htmlspecialchars($_GET["search"]);
}
else {
    $search = "";
}

$idIndex = 0;
$kurzTitleIndex = 1;

$booksPerPage = 18;

$conn = connectToDb();

$kategorien = [];
$verkauft = [];
$zustaende = [];

$query = "SELECT distinct kategorie from book.kategorien";
$result = $conn->query($query);
foreach ($result->fetch_all() as $row) {
    $kategorien[] = $row[0];
}

$query = "SELECT distinct verkauft from book.buecher";
$result = $conn->query($query);
foreach ($result->fetch_all() as $row) {
    $verkauft[] = $row[0];
}

$query = "SELECT distinct zustand from book.buecher";
$result = $conn->query($query);
foreach ($result->fetch_all() as $row) {
    $zustaende[] = $row[0];
}

?>


<html lang="de">
<head>
    <link rel="stylesheet" href="../index.css">
    <title>Search</title>
</head>

<body>

<?php include "../components/header.php"; ?>

<div class="search_container">

    <div class="searchbar">
        <form "index.php" method="get" class="search_form">
        <button class="searchbutton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        <input class="searchfield" type="text" placeholder="search..." name="search" />
        </form>
    </div>



    <div class="advancedsearch">
    <div class="options">
        <form action="/search/index.php" method="get" class="advancedsearch_form">
            <?php
            echo sprintf("<input name=\"search\" value=\"%s\" type=\"hidden\" />", $search);

            ?>

            <select name="sortBy" onchange="this.form.submit()">
                <option value="" disabled selected>Sort by <i class="fa-solid fa-chevron-down"></i></option>
                <?php
                foreach ($sortByColumns as $sortByColumn) {
                    echo sprintf("<option value=\"%s\">%s</option>", $sortByColumn, $sortByColumn);
                }
                ?>
            </select>
            <?php
            if (isset($_GET["filter"])) {
                echo sprintf("<input name=\"filter\" value=\"%s\" type=\"hidden\" />", $_GET["filter"]);
            }
            ?>
        </form>
        <form action="/search/index.php" method="get" class="advancedsearch_form">
            <?php
            echo sprintf("<input name=\"search\" value=\"%s\" type=\"hidden\" />", $search);
            echo sprintf("<input name=\"sortBy\" value=\"%s\" type=\"hidden\" />", $sortBy);
            ?>
            <select name="filter" onchange="this.form.submit()">
                <option value="" disabled selected>Filter <i class="fa-solid fa-chevron-down"></i></option>
                <?php
                echo "<option disabled>Kategorien</option>";
                foreach ($kategorien as $kategorie) {
                    echo sprintf("<option value=\"1%s\">%s</option>", $kategorie, $kategorie);
                }

                echo "<option disabled>Verkauft</option>";
                foreach ($verkauft as $value) {
                    echo sprintf("<option value=\"2%s\">%s</option>", $value, $value);
                }

                echo "<option disabled>Zustände</option>";
                foreach ($zustaende as $zustand) {
                    echo sprintf("<option value=\"3%s\">%s</option>", $zustand, $zustand);
                }
                ?>
            </select>
        </form>
    </div>

    <div class="mainDiv">
        <?php
        $pageCount = 0;
        if (isset($_GET["filter"])) {
            $filterChoice = '';
            switch ($_GET["filter"][0]) {
                case '1':
                    $filterChoice = "kategorie";
                    $filter = htmlspecialchars($_GET["filter"]);
                    $kategorie = substr($filter, 1);

                    $query = sprintf("SELECT COUNT(buecher.id) FROM book.buecher, book.kategorien
                        WHERE kurztitle LIKE '%%%s%%' AND kategorien.kategorie = '%s' AND 
                        buecher.kategorie = kategorien.id ORDER BY buecher.%s", $search, $kategorie, $sortBy);
                    $result = $conn->query($query);
                    $pageCount = $result->fetch_row();

                    $query = sprintf("SELECT buecher.id, kurztitle FROM book.buecher, book.kategorien
                        WHERE kurztitle LIKE '%%%s%%' AND kategorien.kategorie = '%s' AND 
                        buecher.kategorie = kategorien.id ORDER BY buecher.%s 
                        LIMIT %d, %d", $search, $kategorie, $sortBy, $pageNumber * $booksPerPage, $booksPerPage);
                    break;
                case '2':
                    $filterChoice = "verkauft";
                    $filter = htmlspecialchars($_GET["filter"]);
                    $verkauft = substr($filter, 1);

                    $query = sprintf("SELECT COUNT(buecher.id) FROM book.buecher
                        WHERE kurztitle LIKE '%%%s%%' AND buecher.verkauft = %s ORDER BY buecher.%s",
                        $search, $verkauft, $sortBy);
                    $result = $conn->query($query);
                    $pageCount = $result->fetch_row();

                    $query = sprintf("SELECT buecher.id, kurztitle FROM book.buecher
                        WHERE kurztitle LIKE '%%%s%%' AND buecher.verkauft = %s ORDER BY buecher.%s 
                        LIMIT %d, %d", $search, $verkauft, $sortBy, $pageNumber * $booksPerPage, $booksPerPage);
                    break;
                case '3':
                    $filterChoice = "zustand";
                    $filter = htmlspecialchars($_GET["filter"]);
                    $zustand = substr($filter, 1);

                    $query = sprintf("SELECT COUNT(buecher.id) FROM book.buecher
                        WHERE kurztitle LIKE '%%%s%%' AND buecher.zustand = '%s' ORDER BY buecher.%s",
                        $search, $zustand, $sortBy);
                    $result = $conn->query($query);
                    $pageCount = $result->fetch_row();

                    $query = sprintf("SELECT buecher.id, kurztitle FROM book.buecher
                        WHERE kurztitle LIKE '%%%s%%' AND buecher.zustand = '%s' ORDER BY buecher.%s 
                        LIMIT %d, %d", $search, $zustand, $sortBy, $pageNumber * $booksPerPage, $booksPerPage);
                    break;
            }
        }
        else {
            $query = sprintf("SELECT COUNT(buecher.id), kurztitle FROM book.buecher
                        WHERE kurztitle LIKE '%%%s%%' ORDER BY buecher.%s", $search, $sortBy);
            $result = $conn->query($query);
            $pageCount = $result->fetch_row();

            $query = sprintf("SELECT buecher.id, kurztitle FROM book.buecher
                        WHERE kurztitle LIKE '%%%s%%' ORDER BY buecher.%s
                        LIMIT %d, %d", $search, $sortBy, $pageNumber * $booksPerPage, $booksPerPage);
        }

        $result = $conn->query($query);
        foreach ($result->fetch_all() as $value) {
            echo "<div class='book_container'>";
            echo "<div class='book_content'>";
            echo sprintf("<img src='../assets/cover%d.jpg' class=book_image>", rand(1, 5));
            echo "<a href='/books?id=" . $value[$idIndex] . " class='book_textfield'>" .
                $value[$idIndex] . ": " . $value[$kurzTitleIndex] . "
                </a>" . "<br> <br>";
            echo "</div>";
            echo "</div>";
        }

/*
<div class="book_container">
    <div class="book_content">

        <div class="book_imageframe">
            <img src="../assets/cover<?= rand(1, 5)?>.jpg" class=book_image>
        </div>

        <div class="book_textfield">
            <h2><?= $bookInfo1[0] ?></h2>
        <p><?= $bookInfo1[1] ?> </p>
        <br><br><br><br><br><br>
        <h1 class="book_price"><?= floatval($bookInfo1[2]) / 100 ?></h1>
    </div>

    </div>
</div>
*/
        $pageCount = $pageCount[0] / $booksPerPage ?? 0;

        $linkBuilder = "&search=" . $search;

        $tmp = [];

        echo "<div>";

        if (isset($_GET["sortBy"])) {
            $linkBuilder = $linkBuilder . "&sortBy=" . $sortBy;
        }
        if (isset($_GET["filter"])) {
            $linkBuilder = $linkBuilder . "&filter=" . str_replace(' ', '+', $filter);
        }
        for ($i = 0; $i < ($pageCount); $i++) {
            if ($i == $pageNumber) {
                $tmp[] = "<b>" . $pageNumber + 1 . "</b>";
            }
            else {
                $tmp[] = "<a href='?page=" . $i . $linkBuilder . "'> " . ($i + 1) . " </a>";
            }
        }

        for ($i = count($tmp) - 3; $i > 2; $i--) {
            // echo $i . ": " . abs($pageNumber - $i - 1) . "<br>";
            if (abs($pageNumber - $i - 1) > 2) {
                unset($tmp[$i]);
            }
        }

        // echo "<a href='?page=" . $i . $linkBuilder . "'> " . ($i + 1) . " </a>";
        echo "</div>";

        if(count($tmp) > 1) {
            echo "<p>";

            if($pageNumber > 1) {
                // display 'Prev' link
                echo "<a href=\"?page=" . ($pageNumber - 1) . $linkBuilder . "\">&laquo; Prev</a> | ";
            } else {
                echo "Page ";
            }

            $lastlink = 0;
            foreach($tmp as $i => $link) {
                if($i > $lastlink + 1) {
                    echo " ... "; // where one or more links have been omitted
                } elseif($i) {
                    echo " | ";
                }
                echo $link;
                $lastlink = $i;
            }

            if($pageNumber <= $lastlink) {
                // display 'Next' link
                echo " | <a href=\"?page=" . ($pageNumber + 1) . $linkBuilder . "\">Next &raquo;</a>";
            }

            echo "</p>\n\n";
        }

        ?>
    </div>

</div>
    <?php include "../components/footer.php"; ?>
</body>
</html>
