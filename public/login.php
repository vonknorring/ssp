<?php include "../header.php"; ?>
<?php
if($_POST){
    $user = $_POST["username"];
    $email = $_POST["email"];
    $sql = "SELECT * FROM users WHERE username = '$user' AND email = '$email'";
    $result = $conn->query($sql);
    $userdatafromdb = $result->fetch_assoc();


if(password_verify($_POST["password"], $userdatafromdb["password"])){
        $_SESSION["userid"] = $userdatafromdb["userid"];
        $_SESSION["name"] = $userdatafromdb["username"];
        header("Location: /profile.php");
        exit();
    }
    else{
        echo "fel lösen eller användarnamna";
    }
}
?>
<div id="loginDiv">
    <p>skapa en profil/användare här: <a href="register.php">skapa användare</a></p>
    <form method="post">
        <p>Logga in</p>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="email" name="email" placeholder="Email">
        <input type="submit" name="login" value="Logga in">
    </form>
</div>
