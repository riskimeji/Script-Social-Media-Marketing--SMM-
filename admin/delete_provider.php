<?php
session_start();
include '../mainconfig.php';
if($_SESSION['level'] != 'admin'){
   header('location:../auth/sign-in.php');
}

$id= $_GET['id'];
if($id == null){
    header('location:../admin/provider.php');
}
$query = mysqli_query($conn, "DELETE FROM provider where id = $id");
if($query){
    header('location:../admin/provider.php');
}
?>