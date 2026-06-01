<?php include "../header.php"; ?>

<?php
if(!isset($_SESSION['userid'])){
    header("Location:register.php");
    exit;
}
$userid = $_SESSION["userid"];

$totalGames = 0;

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
            <br>
            <br>
            spela här:<a href="game.php">SPELA<br></a>
            logga ut här: <a href="logout.php">loggout<br></a>
        </div>
        <?php 
        $sql = "SELECT Total_rock, Total_paper, Total_scissors, Total_win, Total_lose, Total_tie, Total_games, WinStreak, Best_WinStreak FROM users WHERE userid = $userid";
        
        $result = $conn->query($sql);
        $stats = $result->fetch_assoc();
        $totalGames = $stats["Total_games"];
        ?>
        <div id="StatsText">
            <div id="StatsWLTSPS">
                <div id="StatsWLT">
                    <?php
                        echo "Vinster: " . $stats["Total_win"] . "<br>";
                        echo "Förluster: " . $stats["Total_lose"] . "<br>";
                        echo "Lika: " . $stats["Total_tie"] . "<br>";
                        echo "Games: " . $stats["Total_games"] . "<br>";
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
                <br>
                <div id="StatsWS">
                    <?php
                        echo "Win Streak: " . $stats["WinStreak"] . "<br>";
                        echo "Bästa Win Streak: " . $stats["Best_WinStreak"] . "<br>";
                    ?>
                </div>
            </div>
            <div id="leaderboard">
                <h3>Leaderboard För Bästa Win Streaks</h3>
                <?php
                $lbsql = "SELECT username, Best_WinStreak FROM users ORDER BY Best_WinStreak DESC LIMIT 5";
                $lbresult = $conn->query($lbsql);
                while($row = $lbresult->fetch_assoc()){
                    echo "<p>" . $row["username"] . ": " . $row["Best_WinStreak"] . "</p>";
                }
                ?>
            </div>
            <br>
            <div id="botstats">
                <h3>Bot-stats</h3>
                
            </div>
        </div>
        <?php
        $sql = "SELECT * from gamestats
                INNER JOIN botstats ON gamestats.gameid = botstats.gameid
                WHERE gamestats.userid={$_SESSION["userid"]} 
                ORDER BY gamestats.gameid DESC LIMIT 10";
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
                    <strong>Game #{$totalGames}</strong><br>
                    Du: $playerChoice<br>
                    Bot: $botChoice<br>
                    $resultText
                </div>";

                $totalGames = $totalGames - 1;
            }
        }
    
    ?>

</body>
</html>