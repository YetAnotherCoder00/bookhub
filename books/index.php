
<?php

$id = $_GET["id"];


// totally secure account management

require "../server/mysqlInterface.php";

$idIndex = 0;
$kurzTitleIndex = 1;
$descriptionIndex = 2;

$conn = connectToDb();

$result = $conn->query("SELECT id, kurztitle, title FROM buecher WHERE id = " . $id);
// print_r($result->fetch_all());

$bookInfo = $result->fetch_row();


?>


<html>

<head>

    <title><?= $bookInfo[$kurzTitleIndex]; ?></title>
    <link rel="stylesheet" href="../index.css">


</head>

<body>
  <?php include "../components/header.php"; ?>


    <div class="book_container">
      <div class="book_content">

        <div class="book_imageframe">
          <img src="../assets/cover1.jpg" class=book_image>
        </div>

        <div class="book_textfield">
          <h2>name</h2> <br>
          <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gb           ergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos            et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
          </p>
            <br><br><br><br><br><br>
          <h1 class="book_price">35.00</h1>
        </div>

      </div>
    </div>


    <?php
        echo $bookInfo[$descriptionIndex];
    ?>

  <?php include "../components/footer.php"; ?>


</body>

</html>
