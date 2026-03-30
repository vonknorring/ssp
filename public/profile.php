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

    <?php 

    $sql = "SELECT * from gamestats
            INNER JOIN botstats ON gamestats.gameid = botstats.gameid
            WHERE gamestats.userid={$_SESSION["userid"]} 
            ORDER BY gamestats.gameid DESC LIMIT 5";
    $results = $conn->query($sql);
    if($results->num_rows > 0) {
        while($gameres = $results->fetch_assoc()){
            echo "<br/>";
            var_dump($gameres);
            
        }
    }
    
    ?>

</body>
</html>