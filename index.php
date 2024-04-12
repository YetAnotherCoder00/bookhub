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

// book 1 = 1, book 2 = 999, book 3 = 712
$books = [];
$result = $conn->query("SELECT kurztitle, title, price FROM buecher WHERE id = 1");
$bookInfo1 = $result->fetch_row();

$result = $conn->query("SELECT kurztitle, title, price FROM buecher WHERE id = 999");
$bookInfo2 = $result->fetch_row();

$result = $conn->query("SELECT kurztitle, title, price FROM buecher WHERE id = 712");
$bookInfo3 = $result->fetch_row();

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
<div class="book_container">
    <div class="book_content">

        <div class="book_imageframe">
            <img src="../assets/cover<?= rand(1, 5)?>.jpg" class=book_image>
        </div>

        <div class="book_textfield">
            <h2><?= $bookInfo2[0] ?></h2>
            <p><?= $bookInfo2[1] ?> </p>
            <br><br><br><br><br><br>
            <h1 class="book_price"><?= floatval($bookInfo2[2]) / 100 ?></h1>
        </div>

    </div>
</div>
<div class="book_container">
    <div class="book_content">

        <div class="book_imageframe">
            <img src="../assets/cover<?= rand(1, 5)?>.jpg" class=book_image>
        </div>

        <div class="book_textfield">
            <h2><?= $bookInfo3[0] ?></h2>
            <p><?= $bookInfo3[1] ?> </p>
            <br><br><br><br><br><br>
            <h1 class="book_price"><?= floatval($bookInfo3[2]) / 100 ?></h1>
        </div>

    </div>
</div>


  <?php
    include "components/footer.php";
  ?>

</body>

</html>

