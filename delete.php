<?php
    session_start();
    if(isset($_GET['src']) && strpos( $_GET['src'],$_SESSION['uid1'])!==False){
        if(file_exists($_GET['src'])){
            if(unlink($_GET['src'])){
                echo "deleted";
            } else{
                echo "not";
            }
        } else{
            echo "file not found";
        }
    }
?>