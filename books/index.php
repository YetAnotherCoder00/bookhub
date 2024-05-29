<?php

include "../server/mysqlInterface.php";

$id = $_GET["id"];

$idIndex = 0;
$kurzTitleIndex = 1;
$descriptionIndex = 2;

$conn = connectToDb();

$result = $conn->query("SELECT verkauft, kurztitle, title, zustand, autor, kategorie, price FROM book.buecher WHERE id = " . $id);
// print_r($result->fetch_all());

$bookInfo = $result->fetch_row();


?>

<!DOCTYPE html>
<html lang="de">

<head>

    <title><?= $bookInfo[$kurzTitleIndex]; ?></title>
    <link rel="stylesheet" href="../index.css">


</head>

<body>
  <?php include "../components/header.php"; ?>

    <div class="content">
      <div class="book_gradient_border">
        <div class="book_container books_book_container">
          <div class="book_content">

            <div class="book_imageframe">
              <img src="../assets/cover<?= rand(1, 5)?>.jpg" class="book_image books_book_image">
            </div>

            <div class="book_textfield">
              <div class="book_content book_infos">
                <h2><?= $bookInfo[1] ?></h2>
                  <p>Autor: <?= $bookInfo[4] ?></p>
                  <p>Kategorie: <?= $bookInfo[5] ?></p>
                  <p>Zustand: <?= $bookInfo[3] ?></p>
                  <p>Verkauft: <?= $bookInfo[0] ?></p>
              </div>
              <div class="book_content book_text">
                <p><?= $bookInfo[2] ?> </p>
              </div>
              <div class="book_content book_price" >
                <p class="book_price_tag">CHF</p>
                <p class="book_price_amount"><?= number_format(floatval($bookInfo[6]) / 100, 2) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?php
        //echo $bookInfo[$descriptionIndex];
    ?>

  <?php include "../components/footer.php"; ?>


</body>

</html>
