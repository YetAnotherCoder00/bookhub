<?php

include "../server/mysqlInterface.php";

// setting default values
$linkBuilder = "";
$booksPerPage = 18;
$search = "";
$pageNumber = 0;
$pageCount = 0;
$sortBy = "id";

$idIndex = 0;
$kurzTitleIndex = 1;
$priceIndex = 2;

$sortByColumns = ["id", "kurztitle", "autor"];
$filterColumns = ["kategorie", "verkauft", "zustand"];

$kategorien = [];
$verkauft = [];
$zustaende = [];

$admin = false;

if (isset($_GET["search"])) {
    $search = htmlspecialchars($_GET["search"]);
    $linkBuilder = "&search=" . $search;
}
if (isset($_GET["sortBy"])) {
    $sortBy = htmlspecialchars($_GET["sortBy"]);
    $linkBuilder .= "&sortBy=" . $sortBy;
}
if (isset($_GET["page"])) {
    $pageNumber = htmlspecialchars($_GET["page"]);
}

// getting data from session
if (isset($_SESSION["username"])) {
    $username = htmlspecialchars($_SESSION["username"]);
}

if (isset($_SESSION["loggedIn"])) {
    $loggedIn = $_SESSION["loggedIn"];
}

if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
    $admin = true;
}

$conn = connectToDb();

// i don't think i could shorten this, since 'kategorien' is its own table
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

<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" href="../index.css">
    <title>Search</title>
</head>

<body>

<?php include "../components/header.php"; ?>

<div class="content">
  <div class="search_container">

    <div class="searchbar">
        <form action="./index.php" method="get" class="search_form">
            <button class="searchbutton" type="submit">
              <img src="../assets/search.svg" alt="search icon" width="32" height="32">
            </button>
            <input class="searchfield" type="text" placeholder="search..." name="search" maxlength="250"/>
        </form>
    </div>



    <div class="advancedsearch">
      <div class="options">
          <form action="./index.php" method="get" class="advancedsearch_form">
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
            <input name="search" value="<?= $search ?>" type="hidden" />
          </form>
          <form action="./index.php" method="get" class="advancedsearch_form">

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

            <!-- hidden inputs, which contain the values of the other forms -->
            <input name="search" value="<?= $search ?>" type="hidden" />
            <input name="sortBy" value="<?= $sortBy ?>" type="hidden" />

          </form>
      </div>
    </div>
  </div>

  <div class="search_result">

    <?php
    $filter = "";
    $filterType = "";
    if (isset($_GET["filter"])) {
        $filter = substr(htmlspecialchars($_GET["filter"]), 1);
        $filterType = htmlspecialchars($_GET["filter"])[0];
        $linkBuilder .= sprintf("&filter=%s", str_replace(' ', '+', $filter));
    }

    $pageCount = getCount($search, $filter, $filterType);

    $rows = getResult($search, $sortBy, $pageNumber, $filter, $filterType);

    // print book results, clean this mess up
    foreach ($rows as $value) {
        echo sprintf("
        <div class='book_search_container'>
          <div class='search_gradient_border'>
            <div class='book_content' id='image'>
              <img src='../assets/cover%d.jpg' class='search_book_image' alt='generic book cover'>
            </div>
            <div class='book_content' id='name'>
              <a href='../books?id=%d' class='book_textfield'>%d: %s</a> 
            </div>
            <div class='book_content price' id='price'>
              <div class='price_tag'>
                <p>CHF</p>
              </div>
              <div class='price_amount'>
                .................
              </div>  
            </div>
          </div>
        </div>
        ", rand(1, 5), $value[$idIndex], $value[$idIndex], $value[$kurzTitleIndex],
        $value[$idIndex], $value[$idIndex]);
    }

//    <a href='../admin/update.php?id=%d' class='book_textfield'>update</a>         // update button
//    <a href='../admin/delete.php?id=%d' class='book_textfield'>delete</a>         // delete button



    // todo: make pagination simpler
    $tmp = [];

    echo "<div>";
    for ($i = 0; $i < ($pageCount); $i++) {
        if ($i == $pageNumber) {
            $tmp[] = "<b>" . $pageNumber + 1 . "</b>";
        }
        else {
            $tmp[] = "<a href='?page=" . $i . $linkBuilder . "'> " . ($i + 1) . " </a>";
        }
    }

    for ($i = count($tmp) - 3; $i > 2; $i--) {
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
