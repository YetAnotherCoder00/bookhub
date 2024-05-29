<?php
include "../server/mysqlInterface.php";

if (isset($_GET["logout"])) {
// unset session variables
	unset($_SESSION["username"]);
	unset($_SESSION["loggedIn"]);
	unset($_SESSION["admin"]);

	header("Location: ../index.php", true);
	die();
}

if (isset($_POST["change"])) {
	if (!isset($_POST["oldPassword"], $_POST["newPassword"]) || strlen($_POST["newPassword"]) < 8) {
		echo "too little information<br>";
		echo "<a href='./index.php'>take me back</a>";
		die();
	}
	if (!isset($_SESSION["username"])) {
		header("Location: ../index.php");
		die();
	}
	$oldPassword = $_POST["oldPassword"];
	$newPassword = $_POST["newPassword"];
	$conn = connectToDb();
	$stmt = $conn->prepare("SELECT benutzername, passwort FROM benutzer WHERE benutzername = ?");

	$stmt->bind_param("s", $_SESSION["username"]);
	$stmt->execute();

	$user = $stmt->get_result()->fetch_row();

	if (!password_verify($oldPassword, $user[1])) {
		echo "who are you? (incorrect password)<br>";
		echo "<a href='./index.php'>take me back</a>";
		die();
	}

	$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

	$stmt = $conn->prepare("UPDATE benutzer SET passwort = ? WHERE benutzername = ?");
	$stmt->bind_param("ss", $hashedPassword, $_SESSION["username"]);
	$stmt->execute();
	echo "all done :)";

}

?>

<!DOCTYPE html>
<html lang="de">
<head>
	<title>Logout / password change</title>
	<link rel="stylesheet" href="../index.css">
</head>
<body>
<?php include "../components/header.php" ?>
<div class="content">
	<div class="login_gradient_border">
		<div class="login_panel">
			<div class="login_title">
				<h3>
					Change Password / Log out
				</h3>
			</div>
			<div class="login_form">
				<form action="./index.php" method="post" class="register_container">
					<div class="login_inputs">
						<!-- old password *could* be shorter than 8 characters, but new one *has* to be longer than 8. -->
						<div>
							<label for="oldPassword">Old Password: </label>
							<input type="password" id="oldPassword" name="oldPassword" placeholder="old password">
						</div>
						<div>
							<label for="newPassword">New Password: </label>
							<input type="password" id="newPassword" name="newPassword" placeholder="new password" minlength="8">
						</div>
						<div class="login_submit_container">
							<button type="submit" name="change" value="1" class="login_button">submit change</button>
							<a href="./index.php?logout=1" class="register_link">logout</a>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
<?php include "../components/footer.php" ?>
</body>
</html>
