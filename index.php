<?php

include "server/mysqlInterface.php";

// setting default values
$booksPerPage = 18;
$pageNumber = 0;
$sortBy = "id";

// declare which column contains which data
$idIndex = 0;
$kurzTitleIndex = 1;
$titleIndex = 2;
$priceIndex = 3;

$username = "";
$loggedIn = false;

// getting data from the url
if (isset($_GET["page"])) {
    $pageNumber = htmlspecialchars($_GET["page"]);
}

if (isset($_GET["sortBy"])) {
    $sortBy = htmlspecialchars($_GET["sortBy"]);
}

// getting data from session
if (isset($_SESSION["username"])) {
    $username = htmlspecialchars($_SESSION["username"]);
}

if (isset($_SESSION["loggedIn"])) {
    $loggedIn = htmlspecialchars($_SESSION["loggedIn"]);
}


$conn = connectToDb();

// choose predetermined books
$bookData = [];
$selectedBooks = [1, 99, 712];

$query = "SELECT id, kurztitle, title, price FROM buecher WHERE id = ";

for ($i = 0; $i < count($selectedBooks); $i++) {
    $query .= $selectedBooks[$i];
    if ($i < count($selectedBooks) - 1) {
        $query .= " OR id = ";
    }
}

$result = $conn->query($query);

foreach ($result->fetch_all() as $row) {
    $bookData[] = $row;
}

?>

<!DOCTYPE HTML>
<html lang="de">
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
          <button class="searchbutton" type="submit">
            <img src="assets/search.svg" alt="search icon" width="32" height="32">
          </button>
          <input class="searchfield" type="text" placeholder="search..." name="search" />
        </form>
      </div>

    </div>

<?php

foreach ($bookData as $book) {
    echo "
    <a href='books?id=". $book[$idIndex] . "'>
    <div class='book_container'>
        <div class='book_content'>
            <div class='book_imageframe'>
                <img src='../assets/cover" . rand(1, 5) . ".jpg' class=book_image>
            </div>
            <div class='book_textfield'>
                <h2>" . $book[$kurzTitleIndex] . "</h2>
                <p>" . $book[$titleIndex] . "</p>
                <br><br><br><br><br><br>
                <h1 class='book_price'>" . floatval($book[$priceIndex]) / 100 . "</h1>
            </div>
        </div>
    </div>
    </a>
        ";

}

include "components/footer.php";

?>

  </div>
</body>

</html>