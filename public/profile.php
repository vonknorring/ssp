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
    <div id="profileStatsDiv">
        <div id="Welcome">
            Välkommen <?php echo $_SESSION["name"]; ?> här är din profil med statistik:
            <br/>
            spela här:<a href="game.php">SPELA<br></a>
            logga ut här: <a href="logout.php">loggout<br></a>
        </div>
        <?php 
        $sql = "SELECT Total_rock, Total_paper, Total_scissors, Total_win, Total_lose, Total_tie, Total_games, WinStreak, Best_WinStreak FROM users WHERE userid = $userid";
        
        $result = $conn->query($sql);
        $stats = $result->fetch_assoc();
        ?>
        <div id="StatsText">
            <div id="StatsWLT">
                <?php
                    echo "Vinster: " . $stats["Total_win"] . "<br>";
                    echo "Förluster: " . $stats["Total_lose"] . "<br>";
                    echo "Lika: " . $stats["Total_tie"] . "<br>";
                ?>
            </div>
            <br>
            <div id="StatsSPS">
                <?php
                    echo "Sten: " . $stats["Total_rock"] . "<br>";
                    echo "Påse: " . $stats["Total_paper"] . "<br>";
                    echo "Sax: " . $stats["Total_scissors"] . "<br>";
                ?>
            </div>
            <div id="StatsWS">
                <?php
                    echo "Win Streak: " . $stats["WinStreak"] . "<br>";
                    echo "Best Win Streak: " . $stats["Best_WinStreak"] . "<br>";
                ?>
            </div>
        </div>
        <?php
        $sql = "SELECT * from gamestats
                INNER JOIN botstats ON gamestats.gameid = botstats.gameid
                WHERE gamestats.userid={$_SESSION["userid"]} 
                ORDER BY gamestats.gameid DESC LIMIT 5";
        $results = $conn->query($sql);
        ?>
    </div>
    <?php
    
        if($results->num_rows > 0) {
            while($gameres = $results->fetch_assoc()){
                echo "<br/>";
                if($gameres["rock"] == 1) $playerChoice = "Sten";
                elseif($gameres["paper"] == 1) $playerChoice = "Påse";
                else $playerChoice = "Sax";
                echo "<br/>";
                if($gameres["b-rock"] == 1) $botChoice = "Sten";
                elseif($gameres["b-paper"] == 1) $botChoice = "Påse";
                else $botChoice = "Sax";
                if($gameres["win"] == 1) $resultText = "Du vann!";
                elseif($gameres["lose"] == 1) $resultText = "Du förlorade!";
                else $resultText = "Lika!";

                echo "<div id='GameHistory'>
                    <strong>Game #{$gameres['gameid']}</strong><br>
                    Du: $playerChoice<br>
                    Bot: $botChoice<br>
                    $resultText
                </div>";
            }
        }
    
    ?>

</body>
</html>