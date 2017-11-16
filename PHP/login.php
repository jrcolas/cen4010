<?php
	
	session_start();

	$error = "";

	if (array_key_exists("logout", $_GET)) {

		unset($_SESSION);
		setcookie("studentid", "", time() -60 * 60);
		$_COOKIE["studentid"] = "";

		session_destroy();

	} else if ((array_key_exists("studentid", $_SESSION) AND $_SESSION['studentid']) OR (array_key_exists("studentid", $_COOKIE) AND $_COOKIE['studentid'])) {

		header("Location: myaccount.php");
	}

	if (array_key_exists("submit", $_POST)) {

		include("connection.php");

		if (!$_POST['studentid']) {

			$error .= "A student ID is required.<br>";
		}

		if (!$_POST['password']) {

			$error .= "A password is required.<br>";
		}

		if ($error != "") {

			$error = "<p>There were error(s) in your form:</p>".$error;

// Logging into the page

		} else {

			$query = "SELECT * FROM `users` WHERE studentid = '".mysqli_real_escape_string($link, $_POST['studentid'])."'";

			$result = mysqli_query($link, $query);

			$row = mysqli_fetch_array($result);

			if (isset($row)) {
				$inputPassword = $_POST['password'];

				if ($inputPassword == $row['password']) {

					$_SESSION['studentid'] = $row['studentid'];
					setcookie("studentid", $row['studentid'], time() + 60*60*24*365);
					header("Location: myaccount.php");

				} else {
					$error = "That account could not be found.";
				}

			} else {

				$error = "That account could not be found.";
			}
		} 
	}

?>




<div id="error"><?php echo $error; ?></div>

<head>
		<title>Log In | Enrollifier</title>
</head>
<div id="containerHead">
		<p><h1>Enrollifier</h1></p>
		<p>Login Page</p>
</div>

<form method = "post">

    <p><input name="studentid" type="text" placeholder="Student ID"></p>
    
    <p><input name="password" type="password" placeholder="Password"></p>

    <input type="hidden" name="logIn" value="1">
    
    <p><input name="submit" type="submit" value = "Sign in!"></p>

</form>