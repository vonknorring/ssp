<?php include "../header.php"; ?>
<?php

if(!isset($_SESSION['userid'])){
    header("Location:register.php");
    exit;
}
    ?>