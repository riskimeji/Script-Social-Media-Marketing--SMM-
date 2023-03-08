<?php
session_start();
include '../mainconfig.php';
if($_SESSION['level'] != 'admin'){
   header('location:../auth/sign-in.php');
}

$id= $_GET['id'];
if($id == null){
    header('location:../admin/news.php');
}
$query = mysqli_query($conn, "DELETE FROM news where id = $id");
if($query){
    header('location:../admin/news.php');
}
?>