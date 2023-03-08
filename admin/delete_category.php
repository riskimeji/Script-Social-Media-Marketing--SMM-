<?php
session_start();
include '../mainconfig.php';
if($_SESSION['level'] != 'admin'){
   header('location:../auth/sign-in.php');
}

$id = $_GET['id'];
if($id == null){
    header('location:../admin/index.php');
}
$delete = mysqli_query($conn, "DELETE FROM category where id = '$id'");
if($delete){
    header('location:../admin/category.php');
}
?>