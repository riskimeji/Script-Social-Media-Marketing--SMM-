<?php
include '../../mainconfig.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $query = mysqli_query($conn, "SELECT * FROM service WHERE category = '$id' and status = 'aktif'");
   // $cek = mysqli_num_rows($query); // cek data
   $result = mysqli_fetch_array($query);
   echo json_encode($result);
}
?>