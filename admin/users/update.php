<?php
include "../../server/mysqlInterface.php";

if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin" || (!isset($_GET["id"]) && !isset($_POST["id"]))) {
    header("Location: ../index.php");
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
    <title>update user <?= $id; ?></title>
</head>
<body>

<?php

$conn = connectToDb();

$columns = ["kid" => 0, "geburtstag" => 1, "vorname" => 2, "name" => 3, "geschlecht" => 4, "kunde_seit" => 5,
    "email" => 6, "kontaktpermail" => 7];

if (isset($_POST["update"])) {
    foreach ($columns as $key => $value) {
        if ($key == "kontaktpermail" || $key == "kid") {
            continue;
        }
        if (!isset($_POST[$key])) {
            echo "not enough data";
            return;
        }
    }

    $geburtstag = htmlspecialchars(trim($_POST["geburtstag"]));
    $vorname = htmlspecialchars(trim($_POST["vorname"]));
    $name = htmlspecialchars(trim($_POST["name"]));
    $geschlecht = htmlspecialchars(trim($_POST["geschlecht"]));
    $kunde_seit = htmlspecialchars(trim($_POST["kunde_seit"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $kontaktpermail = isset($_POST["kontaktpermail"]) ? 1 : 0;

    $query = $conn->prepare("UPDATE kunden SET geburtstag = ?, vorname = ?, name = ?, geschlecht = ?,
     kunde_seit = ?, email = ?, kontaktpermail = ? WHERE kid = ?");

    $query->bind_param("ssssssii", $geburtstag, $vorname, $name, $geschlecht, $kunde_seit, $email, $kontaktpermail,
        $id);

    $query->execute();

    echo "<meta http-equiv='refresh' content='0; URL=\"./index.php\"; '/>";
}
else {
    $query = $conn->prepare("SELECT * FROM kunden WHERE kid = ?");
    $query->bind_param("i", $id);

    $query->execute();

    $kunde = $query->get_result()->fetch_row();
    print_r($kunde);
?>

<form action='./update.php' method='post'>
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="date" name="geburtstag" placeholder="geburtstag" required="required" value="<?= $kunde[$columns["geburtstag"]] ?>">
    <input type="text" name="name" placeholder="name" required="required" value="<?= $kunde[$columns["name"]] ?>">
    <input type="text" name="vorname" placeholder="vorname" required="required" value="<?= $kunde[$columns["vorname"]] ?>">
    F:
    <input type="radio" name="geschlecht" placeholder="geschlecht" required="required" value="F" <?php if ($kunde[$columns["geschlecht"]] == "F") { echo "checked"; }?>>
    M:
    <input type="radio" name="geschlecht" placeholder="geschlecht" required="required" value="M" <?php if ($kunde[$columns["geschlecht"]] == "M") { echo "checked"; }?>>
    <input type="date" name="kunde_seit" placeholder="kunde_seit" required="required" value="<?= $kunde[$columns["kunde_seit"]] ?>">
    <input type="text" name="email" placeholder="email" required="required" value="<?= $kunde[$columns["email"]] ?>">
    <input type="checkbox" name="kontaktpermail" placeholder="kontaktpermail" value="1" <?php if (isset($kunde[$columns["kontaktpermail"]]) && $kunde[$columns["kontaktpermail"]] == 1) { echo "checked"; } ?>>
    <button type="submit" name="update" value="update">update here</button>
</form>
<?php
}

?>
</body>