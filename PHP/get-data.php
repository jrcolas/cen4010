<?php
	if(!empty($_POST["enroll"])) {
		
		$queryEnroll = "UPDATE courses SET status = (CASE WHEN seats > 0 THEN 'Open' WHEN seats < 1 THEN 'Closed' END)";
		echo $output;
	}
>