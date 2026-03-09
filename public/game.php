<?php include "../header.php"; ?>
<?php

if(!isset($_SESSION['userid'])){
    header("Location:register.php");
    exit;
} 
$userid = $_SESSION["userid"];

if(isset($_POST["choice"])){
    $choices = ["rock","paper","scissors"];
    $bot =  $choices[array_rand($choices)];
    $player = $_POST["choice"];
    if($player == $bot){
        $result = "tie";
    }
    elseif(
        ($player == "rock" && $bot == "scissors") ||
        ($player == "paper" && $bot == "rock") ||
        ($player == "scissors" && $bot == "paper")
    ){
        $result = "win";
    }
    else{
        $result = "loss";
    }
    echo "Du valde: " . $player . "<br>";
    echo "Botten valde: " . $bot . "<br>";
    echo "Resultat: " . $result . "<br>";
    if($result == "win"){
        $sql = "UPDATE gamestats SET win = win + 1 WHERE userid = $userid";
    }
    elseif($result == "loss"){
        $sql = "UPDATE gamestats SET lose = lose + 1 WHERE userid = $userid";
    }
    else{
        $sql = "UPDATE gamestats SET tie = tie + 1 WHERE userid = $userid";
    }

    $conn->query($sql);
}
?>
<form method="post">
    <button name="choice" value="rock">Sten</button>
    <button name="choice" value="paper">Sax</button>
    <button name="choice" value="scissors">Påse</button>
</form>