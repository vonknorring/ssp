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

    $stmt = $conn->prepare("INSERT INTO gamestats(rock, paper, scissors, userid, win, tie, lose) VALUE(?,?,?,?,?,?,?)");
    $weapon = array("rock" => 0,"paper" => 0,"scissors" => 0);
    $weapon[$player] = 1;
    $gameOutcome = array("win"=>0,"tie"=>0,"lose"=>0);
    $stmt->bind_param("iiiiiii", $weapon["rock"],$weapon["paper"],$weapon["scissors"], $userid,$gameOutcome["win"],$gameOutcome["tie"],$gameOutcome["lose"]);
    $stmt->execute();
    $stmt->close();
    $last_id = $conn->insert_id;
    
$sql = "SELECT * FROM gamestats WHERE gameid=$last_id";

$result = $conn->query($sql);
var_dump($result->fetch_assoc());

$hidden = "playagain";

}




?>
<style>
    a{
        display:none;
    }
    a.playagain {
        display:block;
    }
    form.playagain{
        display:none
    }
</style>

<a href="#" class="<?php echo $hidden; ?>">play again?</a>
<form class="<?php echo $hidden; ?>" method="post">
    <button name="choice" value="rock">Sten</button>
    <button name="choice" value="paper">Sax</button>
    <button name="choice" value="scissors">Påse</button>
</form>