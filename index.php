<?php
session_start();
echo "Hello " . $_SESSION['username'];
if(!isset($_SESSION['username'])){
    header ("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<a href="logout.php">logout</a>
  <?php
include "database.php";

$obj = new DATABASE();

$obj->select('users',"*",null,null,null,null);
echo "<br>Select result is : " ;

$result = $obj->getResult();

echo "<table border = '1' width = '500px'>
<tr>
<th>no</th>
<th>firstname</th>
<th>lastname</th>
<th>email</th>
<th>hobbie</th>
<th>mobile</th>
<th>gender</th>
<th>img</th>
<th>city</th>
<th>password</th>
<th></th>
</tr>";
foreach($result as list("id" => $no  ,
"firstname" => $firstname,
"lastname" => $lastname,
 "email" => $email ,
 "password" => $password,
 "hobbie"=>$hobbie,
 "mobile"=>$mobile,
 "gender"=>$gender,
 "img"=>$img,
 "city"=> $city )){
    echo "<tr>
    <td>$no </td>
    <td>$firstname </td>
    <td>$lastname </td>
    <td>$email </td>
    <td>$hobbie </td>
    <td>$mobile </td>
    <td>$gender </td>
    <td><img src='upload/".$img."' width='100px'></td>
    <td> $city </td>
    <td> $password</td>
    <td><a href='delete.php?id=$no'>delete</a></td> 
    <td><a href='update.php?id=$no'>Update</a></td> 
    </tr>";
}

echo "</TABLE>";
?>
</body>

</html>