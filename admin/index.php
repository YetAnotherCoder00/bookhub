<?php
include "../server/mysqlInterface.php";

if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
	header("Location: ../index.php");
	die();
}
?>

<head>
  <title>admin stuff</title>
  <link rel="stylesheet" href="../index.css">

  <style>
    form * {
      color: black;
    }
  </style>
</head>
<body>

<?php include "../components/header.php"; ?>

  <?php

  $conn = connectToDb();

  if (isset($_POST["create"])) {
    if ($_POST["create"] == "user") {
      // handle user

      if (isset($_POST["name"], $_POST["vorname"], $_POST["password"], $_POST["email"], $_POST["geburtstag"],
        $_POST["geschlecht"])) {
        echo "set enough";
        $name = htmlspecialchars(trim($_POST["name"]));
        $vorname = htmlspecialchars(trim($_POST["vorname"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $geburtstag = htmlspecialchars(trim($_POST["geburtstag"]));
        $kontaktperemail = isset($_POST["kontaktperemail"]);
        $geschlect = $_POST["geschlecht"];
        $currentDate = date("Y-m-d");

        // kid doesn't have a default / automatic value, so here is a messy workaround
        $result = $conn->query("SELECT * FROM kunden ORDER BY kid DESC LIMIT 1");
        $kid = $result->fetch_row()[0] + 1;

        // yes, everything *needs* to be filled out, nothing has a default / automatic value
        $preparedQuery = $conn->prepare("INSERT INTO kunden (
          kid, name, vorname, email, geburtstag, kontaktpermail, kunde_seit, geschlecht) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $preparedQuery->bind_param("issssiss", $kid, $name, $vorname, $email, $geburtstag,
          $kontaktperemail, $currentDate, $geschlect);
        $preparedQuery->execute();
      }
      else {
        echo "not set enough";
      }
    }
    else if ($_POST["create"] == "book") {
      // handle book
      $check = ["katalog", "nummer", "kurztitle", "kategorie", "kaufer", "autor", "title", "foto",
        "verfasser", "zustand", "price"];

      foreach ($check as $checking) {
        if (!isset($_POST[$checking])) {
          echo "not set enough";
          return;
        }
      }

      $katalog = intval($_POST["katalog"]);
      $nummer = intval($_POST["nummer"]);
      $kurztitle = htmlspecialchars(trim($_POST["kurztitle"]));
      $kategorie = intval($_POST["kategorie"]); // i think this should be a drop-down
      $kaufer = intval($_POST["kaufer"]);
      $autor = htmlspecialchars(trim($_POST["autor"]));
      $title = htmlspecialchars(trim($_POST["title"]));
      $sprache = htmlspecialchars(trim($_POST["sprache"]));
      $foto = $_FILES["foto"];
      $verfasser = intval($_POST["verfasser"]);
      $zustand = htmlspecialchars(trim($_POST["zustand"]));
      $price = intval($_POST["price"]);

      $verkauft = isset($_POST["verkauft"]);

      echo "continuing";

			$query = sprintf(
				"INSERT INTO buecher (
				    katalog, nummer, kurztitle, kategorie, verkauft, kaufer, autor, title, sprache, foto, verfasser, zustand, price
				) VALUES (
				    %d, %d, %s, %d, %d, %d, %s, %s, %s, %s, %d, %s, %d
				)",
        $katalog, $nummer, $kurztitle, $kategorie, $verkauft, $kaufer, $autor, $title, $sprache, $foto, $verfasser,
        $zustand, $price
			);

			$result = $conn->query($query);

  //    $preparedQuery = $conn->prepare("INSERT INTO buecher (katalog, nummer, kurztitle, kategorie, kaufer, autor, title, sprache, verfasser, zustand, price)");

    }
    else if ($_POST["create"] == "image") {
      $target_dir = "../images/";
      $target_file = $target_dir . basename($_FILES["userImage"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["userImage"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
      if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file)) {
          echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }
    }
  }
  ?>

<div class="content">

  <div class="create_gradient_border">
    <div class="create_container">
      <form action="index.php" method="post" class="create_customer_form">
        <!--  <input type="checkbox" hidden="hidden" checked="checked" name="creating" value="user">-->
        <input type="text" name="name" placeholder="name" required="required">
        <input type="text" name="vorname" placeholder="vorname" required="required">
        <input type="password" name="password" placeholder="password" required="required">
        <input type="email" name="email" placeholder="email" required="required">
        <input type="date" name="geburtstag" placeholder="geburtstag" required="required">
        M:
        <input type="radio" name="geschlecht" value="M">
        F:
        <input type="radio" name="geschlecht" value="F">
        kontakt per email:
        <input type="checkbox" name="kontaktperemail" placeholder="kontaktperemail">
        <button type="submit" name="create" value="user">submit the flesh of the user</button>
      </form>
    </div>
  </div>

  <div class="create_gradient_border">
    <div class="create_container">
      <form action="index.php" method="post" class="create_book_form">
        <!--  <input type="checkbox" hidden="hidden" checked="checked" value="book">-->
        <input type="number" name="katalog" placeholder="katalog" required="required">
        <input type="number" name="nummer" placeholder="nummer" required="required">
        <input type="text" name="kurztitle" placeholder="kurztitle" required="required">
        <input type="number" name="kategorie" placeholder="kategorie" required="required">
        <input type="checkbox" name="verkauft" placeholder="verkauft">verkauft
        <input type="number" name="kaufer" placeholder="kaufer" required="required">
        <input type="text" name="autor" placeholder="autor" required="required">
        <input type="text" name="title" placeholder="title" required="required">
        <input type="text" name="sprache" placeholder="sprache" required="required">
        <input type="file" name="foto" placeholder="foto" required="required" style="color: white">
        <input type="number" name="verfasser" placeholder="verfasser" required="required">
        <input type="text" name="zustand" placeholder="zustand" required="required">
        <input type="number" name="price" placeholder="price" required="required">
        <button type="submit" name="create" value="book">submit the fleshy nature of the book</button>
      </form>
    </div>
  </div>

</div>

  <?php

	include "../components/footer.php";

	?>
</body>
