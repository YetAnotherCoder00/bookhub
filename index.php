<?php

include "server/mysqlInterface.php";

if (!isset($pageNumber)) {
    $pageNumber = 0; // first page
}
else {
    $pageNumber = $_GET["page"];
}

if (!isset($sortBy)) {
    $sortBy = "id";
}
else {
    $sortBy = $_GET["sortBy"];
}


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
        $result = $conn->query("SELECT id, kurztitle FROM buecher ORDER BY " . $sortBy . " LIMIT " . $pageNumber * 18 . ", " . $booksPerPage);

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

        $result = $conn->query("SELECT COUNT(*) FROM buecher");
        $rowCount = $result->fetch_row();

        for ($i = 0; $i < ($rowCount[0] / $booksPerPage); $i++) {
            echo "<a href='?page=" . $i . "&sortBy=" . $sortBy . "'> " . ($i + 1) . " </a>";
        }

        ?>
    </div>

  <?php
    include "components/footer.php";
  ?>

</body>

</html>

