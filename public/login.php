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
<form method="post">
    <p>logga-in</p>
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Passowrd">
    <input type="text" name="email" placeholder="Email">
    <input type="submit" name="login">
</form>
