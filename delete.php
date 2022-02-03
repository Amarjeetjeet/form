<?php

include "database.php";
$obj = new DATABASE();

$id = $_GET['id'];
$obj->delete("users","id = $id");

header("location:index.php");
?>