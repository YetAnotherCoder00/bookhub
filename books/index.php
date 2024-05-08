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
      <div class="book_container">
        <div class="book_content">

          <div class="book_imageframe">
            <img src="../assets/cover<?= rand(1, 5)?>.jpg" class=book_image>
          </div>

          <div class="book_textfield">
            <h2><?= $bookInfo[1] ?></h2>
              <p>Autor: <?= $bookInfo[4] ?></p>
              <p>Kategorie: <?= $bookInfo[5] ?></p>
              <p>Zustand: <?= $bookInfo[3] ?></p>
              <p>Verkauft: <?= $bookInfo[0] ?></p>
            <p><?= $bookInfo[2] ?> </p>
              <br><br><br><br><br><br>
            <h1 class="book_price"><?= floatval($bookInfo[6]) / 100 ?></h1>
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
