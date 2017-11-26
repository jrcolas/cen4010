<?php

    $link = mysqli_connect("localhost", "cen4010g1", "some_password", "cen4010_g1");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }

?>