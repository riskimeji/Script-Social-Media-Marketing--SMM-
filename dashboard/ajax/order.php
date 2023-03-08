<?php
include '../../mainconfig.php';
if(isset($_GET['category'])){
    $id = $_GET['category'];
    $query = mysqli_query($conn, "SELECT * FROM service WHERE category = '$id'");
    $cek = mysqli_num_rows($query); // cek data
    if($cek > 0 ){
        while($row = mysqli_fetch_array($query)){
            echo '<option name="id" value="'.$row['id'].'">'.$row['nama'].'</option>';
        }
    }else{
        echo '<option>Data tidak ditemukan...</option>';
    }
    
}else{
    echo "<h1>Error</h1>";
}

?>