<?php include "../header.php"; ?>
<?php 
if(isset($_SESSION['userid'])){
    header("Location: /profile.php");
    exit;
}?>
<body>
    Logga in i existerande användare: <a href="login.php" id="loginBtn">logga in</a>
    <br>
    <br>
    skapa en användare/profil
    
    <form action="createuser.php" method="post">
        <br>
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="text" name="email" placeholder="Email">
        <input type="submit" name="createuser" value="Create">
        <?php
        ?>
    </form>
    
</body>
</html>