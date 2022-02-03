<?php

if(isset($_POST['submit'])){
    include "database.php";
    
    $obj = new database();
    
    $username= $_POST['username'];
    $passowrd= md5($_POST['password']);
    
     $obj->select("users","*",null,"firstname = '$username' AND password = '$passowrd'",null,null,null);
    
     $result = $obj->getResult();
     if(!empty($result)){
         session_start();
         $_SESSION['username'] = $result[0]['firstname'];
         header ("location:index.php");
     }
     else{
        echo "<h2>Failed</h2>";
     }
    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>

<body>
    <h1>Login page</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
    <?php
    if(isset($_COOKIE['user'])){
        $pro= $_COOKIE['user'];
        echo '<input type="text" name="username" id="name" placeholder="username" value="'. $_COOKIE['user'] .'"><br>';
    }
    else{
        echo '<input type="text" name="username" id="name" placeholder="username" value=""><br>';
    }
    ?>
        <p class="name" id="userError"></p>
        <input type="password" name="password" id="password" placeholder="password"><br>
        <p class="name" id="passwordError"></p>
        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>