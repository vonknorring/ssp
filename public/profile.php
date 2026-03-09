<?php include "../header.php"; ?>

<?php
if(!isset($_SESSION['userid'])){
    header("Location:register.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
</head>
<body>
    Välkommen <?php echo $_SESSION["name"]; ?> här är din profil med statistik:
    <br/>
    spela här:<a href="game.php">SPELA</a>
</body>
</html>