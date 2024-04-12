<?php

include "server/mysqlInterface.php";

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


$idIndex = 0;
$kurzTitleIndex = 1;

$booksPerPage = 18;

$conn = connectToDb();

?>

<html>
<head>
    <link rel="stylesheet" href="index.css">
    <script src="https://kit.fontawesome.com/fb438f2369.js" crossorigin="anonymous"></script>
    <title><?= "Index - Page " . ($pageNumber + 1) ?></title>
</head>

<body>
<?php include "components/header.php"; ?>

  <div class="content" id="top">
  <div class="search_container">

    <div class="searchbar"> 
      <form action="search/index.php" method="get" class="search_form">
          <button class="searchbutton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        <input class="searchfield" type="text" placeholder="search..." name="search" />
      </form>
    </div> 



  </div>
  </div>

  <div class="filter_container">
  </div>

  <div class="slider_container">

    <div class="slider_content">

      <div class="slider_imageframe">
        <a href="[buchseite]" id="slider_imagelink">
        <img src="assets/cover1.jpg" id=slider_image>
        </a>
      </div>

      <div class="slider_textfield">
        <h2>name</h2> <br>
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gub           ergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos            et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
        </p>
          <br><br><br><br><br><br>
        <h1 class="slider_price">35.00</h1>
      </div>

    </div>

    <div class="slider_radiobuttons">
      <input class="sliderradio" name="slider" type="radio" onclick="changeImage(1)" checked="checked">
      <input class="sliderradio" name="slider" type="radio" onclick="changeImage(2)">
      <input class="sliderradio" name="slider" type="radio" onclick="changeImage(3)">
    </div>
  </div>

    <div>
        test
    </div>
    <div class="mainDiv">
    <?php
        $result = $conn->query("SELECT COUNT(id) FROM buecher");
        $pageCount = $result->fetch_row();
        $pageCount = $pageCount[0] / $booksPerPage ?? 0;

        $result = $conn->query("SELECT id, kurztitle FROM buecher ORDER BY " .
            $sortBy . " LIMIT " . $pageNumber * 18 . ", " . $booksPerPage);


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

        $tmp = [];

        echo "<div>";

        for ($i = 0; $i < ($pageCount); $i++) {
            if ($i == $pageNumber) {
                $tmp[] = "<b>" . $pageNumber + 1 . "</b>";
            }
            else {
                $tmp[] = "<a href='?page=" . $i . "'> " . ($i + 1) . " </a>";
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
                echo "<a href=\"?page=" . ($pageNumber - 1) . "\">&laquo; Prev</a> | ";
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
                echo " | <a href=\"?page=" . ($pageNumber + 1) . "\">Next &raquo;</a>";
            }

            echo "</p>\n\n";
        }

        ?>
        ?>
    </div>

  <?php
    include "components/footer.php";
  ?>

</body>

</html>

