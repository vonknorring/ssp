<?php include "../header.php"; ?>

<?php


if(isset($_POST["createuser"])){

    $HESH = password_hash($_POST["password"],PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users(username,password,email) VALUES(?,?,?)");
        $stmt->bind_param("sss", $_POST["username"], $HESH, $_POST["email"]);
        if($stmt->execute()){
            $stmt->close();
            header("Location:login.php");
            exit;
        }else{
            $stmt->close();
            header("Location:register.php");
            exit;
        }
}else{
    header("Location:login.php");
    exit;
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>createuser</title>
</head>
<body>
    
</body>
</html>