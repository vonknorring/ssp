<?php include "../header.php"; ?>

<?php
if(!isset($_SESSION['userid'])){
    header("Location:register.php");
    exit;
}
$userid = $_SESSION["userid"];

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
    spela här:<a href="game.php">SPELA<br></a>
    logga ut här: <a href="logout.php">loggout<br></a>

    <?php 
    $sql = "SELECT Total_rock, Total_paper, Total_scissors, Total_win, Total_lose, Total_tie, Total_games FROM users WHERE userid = $userid";
    
    $result = $conn->query($sql);
    $stats = $result->fetch_assoc();
    
    echo "Wins: " . $stats["Total_win"] . "<br>";
    echo "Losses: " . $stats["Total_lose"] . "<br>";
    echo "Ties: " . $stats["Total_tie"] . "<br>";
    echo "Rock: " . $stats["Total_rock"] . "<br>";
    echo "Paper: " . $stats["Total_paper"] . "<br>";
    echo "Scissors: " . $stats["Total_scissors"] . "<br>";

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