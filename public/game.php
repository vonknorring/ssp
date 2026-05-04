<?php include "../header.php"; ?>

<?php

if(!isset($_SESSION['userid'])){
    header("Location:register.php");
    exit;
} 
$userid = $_SESSION["userid"];
$hidden = "";

if(isset($_POST["choice"])){
    $choices = ["rock","paper","scissors"];
    $bot =  $choices[array_rand($choices)];
    $player = $_POST["choice"];
    if($player == $bot){
    $outcome = "tie";
    }
    elseif(
        ($player=="rock" && $bot=="scissors") ||
        ($player=="paper" && $bot=="rock") ||
        ($player=="scissors" && $bot=="paper")
    ){
        $outcome = "win";
    }
    else{
        $outcome = "lose";
    }
    $stmt = $conn->prepare("INSERT INTO gamestats(rock, paper, scissors, userid, win, tie, lose) VALUES(?,?,?,?,?,?,?)");
    $weapon = array("rock" => 0,"paper" => 0,"scissors" => 0);
    $weapon[$player] = 1;
    $gameOutcome = array("win"=>0,"tie"=>0,"lose"=>0);
    $gameOutcome[$outcome] = 1;
    $stmt->bind_param("iiiiiii", $weapon["rock"],$weapon["paper"],$weapon["scissors"], $userid,$gameOutcome["win"],$gameOutcome["tie"],$gameOutcome["lose"]);
    $stmt->execute();
    $stmt->close();
    $last_id = $conn->insert_id;
    $botWeapon = array("b-rock"=>0, "b-paper"=>0, "b-scissors"=>0);
    $botWeapon["b-".$bot] = 1;

    $stmt = $conn->prepare("INSERT INTO botstats (gameid, userid, `b-rock`, `b-paper`, `b-scissors`) VALUES (?,?,?,?,?)");
    $stmt->bind_param("iiiii",
        $last_id,
        $userid,
        $botWeapon["b-rock"],
        $botWeapon["b-paper"],
        $botWeapon["b-scissors"]
    );
    $stmt->execute();
    $stmt->close();

    $field = "Total_" . $player;
    $conn->query("UPDATE users SET $field = $field + 1 WHERE userid = $userid");

    if($outcome == "win"){
    $conn->query("UPDATE users SET Total_win = Total_win + 1 WHERE userid = $userid");
    $conn->query("UPDATE users SET WinStreak = WinStreak + 1 WHERE userid = $userid");
    $conn->query("UPDATE users SET Best_WinStreak = WinStreak WHERE userid = $userid AND WinStreak > Best_WinStreak");
    }
    elseif($outcome == "lose"){
        $conn->query("UPDATE users SET Total_lose = Total_lose + 1 WHERE userid = $userid");
        $conn->query("UPDATE users SET WinStreak = 0 WHERE userid = $userid");

    }
    else {
        $conn->query("UPDATE users SET Total_tie = Total_tie + 1 WHERE userid = $userid");
        $conn->query("UPDATE users SET WinStreak = 0 WHERE userid = $userid");
    }

    $conn->query("UPDATE users SET Total_games = Total_games + 1 WHERE userid = $userid");


    // lägg till total stats på usern.
    // hitta vilket fält du ska uppdatera
    // gör ett nytt mysql req
    // UPDATE table SET field = field + 1 WHERE id = 1
    
if($player == "rock") $playerText = "Sten";
elseif($player == "paper") $playerText = "Påse";
else $playerText = "Sax";

if($bot == "rock") $botText = "Sten";
elseif($bot == "paper") $botText = "Påse";
else $botText = "Sax";

if($outcome == "win") $outcomeText = "Du vann";
elseif($outcome == "lose") $outcomeText = "Du förlorade";
else $outcomeText = "Lika";

echo "<div id='resultDiv'>
    <p>Du valde: $playerText</p>
    <p>Botten valde: $botText</p>
    <p>$outcomeText</p>
</div>";

$hidden = "playagain";

}




?>

<style>
    a{ display:none; }
    a.playagain { display:block; }
    #GameForm.playagain { display:none; }
</style>


<a href="/game.php" class="<?php echo $hidden; ?>">play again?</a>
<a href="/profile.php" class="<?php echo $hidden; ?>">Till profilen</a>
<form id="GameForm" class="<?php echo $hidden; ?>" method="post">
        <button name="choice" value="rock">🪨</button>
        <button name="choice" value="paper">📄</button>
        <button name="choice" value="scissors">✂️</button>
</form>
