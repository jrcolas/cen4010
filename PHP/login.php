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


<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
        <title>Sign In | Enrollifier</title>
    </head>

    <body>
    	<div><h2>Enrollifier | Sign In</h2></div>

		<div id="error"><?php echo $error; ?></div>

		<div id="login">
            <form name='form-login' method="post">
                <span class="fontawesome-user"></span>
                <input name="studentid" type="text" id="user" placeholder="Panther ID">

                <span class="fontawesome-lock"></span>
                <input name="password" type="password" id="pass" placeholder="Password">

                <input type="hidden" name="logIn' value="1">

                <input name="submit" type="submit" value="Login">

            </form>
        </div>

        <style type="text/css">
            @charset "utf-8"
            @import url(http://weloveiconfonts.com/api/?family=fontawesome);
            [class*="fontawesome-"]:before{
                font-family: 'FontAwesome', sans-serif;
            }
            body{
                background: #2c3338;
                color: #606468;
                font: 87.5%1.5em 'Open Sans', sans-serif;
                margin: 0;
            }
            h2 {
                color: #ffffff;
                font-family: 'Open Sans', Arial, sans-serif;
                text-align: center;
                padding: 22px 0px 22px 0px;
            }
            input{
                border: none;
                font-family: 'Open Sans', Arial, sans-serif;
                font-size: 16px;
                line-height: 1.5em;
                padding: 0;
                -webkit-appearance: none;
            }
            p{
                line-height: 1.5em;
            }
            after{clear: both;}
            #login{
                margin: 50px auto;
                width: 320px;
            }
            #login form{
                margin: auto:
                padding: 22px 22px 22px 22px;
                width: 100%;
                border-radius: 5px;
                background: #282e33;
                border-top: 3px solid #434a52;
                border-bottom: 3px solid #434a52;
            }
            #login form span{
                background-color: #363b41;
                border-radius: 3px 0px 0px 3px;
                border-right: 3px solid #434a52;
                color: #606468;
                display: block;
                float: left;
                line-height: 50px;
                text-align: center;
                width: 50px;
                height: 50px;
            }
            #login form input[type="text"] {
                background-color: #3b4148;
                border-radius: 0px 3px 3px 0px;
                color: #4169e1;
                margin-bottom: 1em;
                padding: 0 16px;
                width: 235px;
                height: 50px;
            }
            #login form input[type="password"] {
                background-color: #3b4148;
                border-radius: 0px 3px 3px 0px;
                color: #FFD700;
                margin-bottom: 1em;
                padding: 0 16px;
                width: 235px;
                height: 50px;
            }
            #login form input[type="submit"] {
                background: #4169e1;
                border: 0;
                width: 100%;
                height: 40px;
                border-radius: 3px;
                color: #FFD700;
                cursor: pointer;
                transition: background 0.3s ease-in-out;
            }
            #login form input[type="submit"]:hover {
                background: #FFD700;
            }
        </style>

	</body>
</html>
