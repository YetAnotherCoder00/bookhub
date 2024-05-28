<?php
include "../server/mysqlInterface.php";

if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin" || (!isset($_GET["id"]) && !isset($_POST["id"]))) {
    header("Location: ../search");
    die();
}

$id = 0;

if (isset($_GET["id"])) {
	$id = intval($_GET["id"]);
}
else if (isset($_POST["id"])) {
	$id = intval($_POST["id"]);
}
?>

<head>
    <title>update book <?= $id; ?></title>
    <link rel="stylesheet" href="../index.css">

    <style>
        form * {
            color: black;
        }
    </style>
</head>
<body>

<?php include "../components/header.php"; ?>

<h1>
    create stuff
</h1>
<?php


$conn = connectToDb();

$columns = ["id" => 0, "katalog" => 1, "nummer" => 2, "kurztitle" => 3, "kategorie" => 4, "verkauft" => 5,
    "kaufer" => 6, "autor" => 7, "title" => 8, "sprache" => 9, "foto" => 10, "verfasser" => 11, "zustand" => 12,
    "price" => 13];

// handle book
$check = ["katalog", "nummer", "kurztitle", "kategorie", "kaufer", "autor", "title", "foto",
    "verfasser", "zustand", "price"];

if (isset($_POST["update"])) {
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
	$foto = $_POST["foto"];
	$verfasser = intval($_POST["verfasser"]);
	$zustand = htmlspecialchars(trim($_POST["zustand"]));
	$price = intval($_POST["price"]);

	$verkauft = isset($_POST["verkauft"]) ? 1 : 0;

  $query = sprintf(
		"UPDATE buecher 
     SET katalog = %d, nummer = %d, kurztitle = '%s', kategorie = %d, verkauft = %d,
        kaufer = %d, autor = '%s', title = '%s', sprache = '%s', foto = '%s', verfasser = %d, zustand = '%s', price = %d
     WHERE id = %d", $katalog, $nummer, $kurztitle, $kategorie, $verkauft, $kaufer, $autor, $title, $sprache, $foto,
		$verfasser, $zustand, $price, $id
	);

  $result = $conn->query($query);

  $result = $conn->query(sprintf("SELECT * FROM buecher WHERE id = '%d'", $id));

  $book = $result->fetch_row();
  echo "<meta http-equiv='refresh' content='0; URL=\"../search\"; '/>";
}
else {


//    $preparedQuery = $conn->prepare("INSERT INTO buecher (katalog, nummer, kurztitle, kategorie, kaufer, autor, title, sprache, verfasser, zustand, price)");

$result = $conn->query(sprintf("SELECT * FROM buecher WHERE id = '%d'", $id));

$book = $result->fetch_row();

?>
<br>
update book!
<form action="update.php" method="post">
    <!--  <input type="checkbox" hidden="hidden" checked="checked" value="book">-->
    <input type="hidden" name="foto" value="image.png">
    <input type="hidden" name="id" value="<?= $_GET["id"] ?>">

    <input type="number" name="katalog" placeholder="katalog" required="required" value="<?= $book[$columns["katalog"]] ?>">
    <input type="number" name="nummer" placeholder="nummer" required="required" value="<?= $book[$columns["nummer"]] ?>">
    <input type="text" name="kurztitle" placeholder="kurztitle" required="required" value="<?= $book[$columns["kurztitle"]] ?>">
    <input type="number" name="kategorie" placeholder="kategorie" required="required" value="<?= $book[$columns["kategorie"]] ?>">
    <input type="checkbox" name="verkauft" placeholder="verkauft" value="1" <?php if($book[$columns["verkauft"]]) {
      echo "checked='checked'";
		}?>>
    <input type="number" name="kaufer" placeholder="kaufer" required="required" value="<?= $book[$columns["kaufer"]] ?>">
    <input type="text" name="autor" placeholder="autor" required="required" value="<?= $book[$columns["autor"]] ?>">
    <input type="text" name="title" placeholder="title" required="required" value="<?= $book[$columns["title"]] ?>">
    <input type="text" name="sprache" placeholder="sprache" required="required" value="<?= $book[$columns["sprache"]] ?>">
<!--    <input type="file" name="foto" placeholder="foto" required="required" style="color: white" value="--><?php //= $book[$columns["foto"]] ?><!--">-->
    <input type="number" name="verfasser" placeholder="verfasser" required="required" value="<?= $book[$columns["verfasser"]] ?>">
    <input type="text" name="zustand" placeholder="zustand" required="required" value="<?= $book[$columns["zustand"]] ?>">
    <input type="number" name="price" placeholder="price" required="required" value="<?= $book[$columns["price"]] ?>">

    <button type="submit" name="update" value="book">submit the fleshy nature of the book</button>
</form>

<!--<form enctype="multipart/form-data" action="create.php" method="post">-->
<!--    <input type="hidden" name="MAX_FILE_SIZE" value="30000">-->
<!--    <input type="file" name="userImage" style="color: white">-->
<!--    <button type="submit" name="create" value="image">submit a fleshy image</button>-->
<!--</form>-->

<h1>list stuff</h1>

<?php
}

include "../components/footer.php";

?>
</body>
