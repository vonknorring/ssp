<?php include "../header.php"; ?>
<?php 
if(isset($_SESSION['userid'])){
    header("Location: /profile.php");
    exit;
}?>
<body>
    skapa en användare/profil
    <form action="createuser.php" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="text" name="email" placeholder="Email">
    <input type="submit" name="createuser" value="Create">
    <?php
    ?>
    </form>
</body>
</html>