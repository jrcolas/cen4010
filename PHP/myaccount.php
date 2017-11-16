<?php
	
	session_start();

	if (array_key_exists("studentid", $_COOKIE)) {

		$_SESSION['studentid'] = $_COOKIE['studentid'];
	}

	if (array_key_exists("studentid", $_SESSION)) {

		include("connection.php");

		$query = "SELECT name FROM `users` WHERE studentid = ".mysqli_real_escape_string($link, $_SESSION['studentid'])." LIMIT 1";
		$row = mysqli_fetch_array(mysqli_query($link, $query));

		$studentName = $row['name'];
		$studentid = $row['studentid'];
 
		echo "<p>Logged In! <a href='login.php?logout=1'>Logout</a></p>";

	} else {

		header("Location: login.php");

	}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>My Account</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){ /* PREPARE THE SCRIPT */
	    	$("#enroll").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
	      		var enroll = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
	      		var dataString = "enroll="+enroll; /* STORE THAT TO A DATA STRING */

	      	$.ajax({ /* THEN THE AJAX CALL */
		        type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
		        url: "get-data.php", /* PAGE WHERE WE WILL PASS THE DATA */
		        data: dataString, /* THE DATA WE WILL BE PASSING */
		        success: function(result){ /* GET THE TO BE RETURNED DATA */
		          $("#show").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
		        }
	      	});

		    });
		  });
		</script>
	</head>
<h1>Welcome <?php echo $studentName ?>!</h1><br>
<h2>Shopping Cart</h2>

<?php //------------------------------------------------------------------------------- 
	// Listing courses in shopping cart for specific student.
?>

<table>
	<tr>
		<th>Course ID</th>
		<th>Course Name</th>
		<th>Availability</th>
		<th>Option</th>
	</tr>

	<?php 
		include("connection.php");
		$queryCart = "SELECT * FROM `cart` WHERE studentid = ".mysqli_real_escape_string($link, $_SESSION['studentid'])."";

		

		if ($result = mysqli_query($link, $queryCart)) {

			while($rowCart = mysqli_fetch_array($result)) {

				//$query2 = "INSERT INTO `cart` (`courseid`) VALUES("print_r(.$row1['id'].)")";
				//$query2 = "INSERT INTO `cart` SET courseid = '98765', status = 'closed'";
				//$addToCart = mysqli_query($link, $query2);

			print_r("<tr>
					<td>".$rowCart['courseid']."</td>
					<td>".$rowCart['courseName']."</td>
					<td>".$rowCart['status']."</td>
					<td><a href='get-data.php' name='enroll' id='enroll'>Enroll</a></td>
			    </tr>") ;
			}


		}
	?>

</table>

<br>

<h2>Schedule</h2>

<table>
	<tr>
		<th>Course ID</th>
		<th>Course Name</th>
		<th>Option</th>
	</tr>

	<?php 
		include("connection.php");
		$queryCart = "SELECT * FROM `schedule` WHERE studentid = ".mysqli_real_escape_string($link, $_SESSION['studentid'])."";

		

		if ($result = mysqli_query($link, $queryCart)) {

			while($rowCart = mysqli_fetch_array($result)) {

				//$query2 = "INSERT INTO `cart` (`courseid`) VALUES("print_r(.$row1['id'].)")";
				//$query2 = "INSERT INTO `cart` SET courseid = '98765', status = 'closed'";
				//$addToCart = mysqli_query($link, $query2);

			print_r("<div id='show'><tr>
					<td>".$rowCart['courseID']."</td>
					<td>".$rowCart['courseName']."</td>
					<td>Drop</td></div>
			    </tr>") ;
			}


		}
	?>

</table>



<br>
<h2>All Courses</h2>


<?php //-------------------------------------------------------------------------------- 
	// Listing all the courses.
?>
<table>
	<tr>
		<th>Course ID</th>
		<th>Course Name</th>
		<th>Availability</th>
		<th>Option</th>
	</tr>

	<?php 
		include("connection.php");
		$query1 = "SELECT * FROM `courses`";

// $query = "INSERT INTO `users` (`email`, `password`) VALUES('tommy@gmail.com', 'ilovemydad')";

		

		if ($result = mysqli_query($link, $query1)) {

			while($row1 = mysqli_fetch_array($result)) {

				//$query2 = "INSERT INTO `cart` (`courseid`) VALUES("print_r(.$row1['id'].)")";
				//$query2 = "INSERT INTO `cart` SET courseid = '98765', status = 'closed'";
				//$addToCart = mysqli_query($link, $query2);

			print_r("<tr>
					<td>".$row1['id']."</td>
					<td>".$row1['courseName']."</td>
					<td>".$row1['status']."</td>
					<td>Add to cart</td>
			    </tr>") ;
			}


		}
	?>

</table>



