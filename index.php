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

  <div class="content">
  <div class="search_container">

    <div class="searchbar"> 
      <form class="search_form">
          <button class="searchbutton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        <input class="searchfield" type="text" placeholder="search..." name="search" />
      </form>
    </div> 



  </div>
  </div>

  <div class="filter_container">
  </div>

  <div class="slider_container">
    <div class="slider_imageframe">
      <a href="[buchseite]" id="slider_imagelink">
      <img src="[binbr> <br>l]" id=slider_image>
      </a>
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

</body>

</html>

