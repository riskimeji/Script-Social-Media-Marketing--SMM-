<?php
include '../../mainconfig.php';
if(isset($_GET['category'])){
    $id = $_GET['category'];
    $query = mysqli_query($conn, "SELECT * FROM service WHERE category = '$id'");
    $cek = mysqli_num_rows($query); // cek data
    if($cek > 0 ){
        while($row = mysqli_fetch_array($query)){
            echo '
            <tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['category'].'</td>
            <td>'.$row['nama'].'</td>
            <td>'.$row['deskripsi'].'</td>
            <td>'.$row['min'].'</td>
            <td>'.$row['max'].'</td>
            <td>'.$row['est_masuk'].'</td>
            <td>'.$row['harga'].'</td>
            </tr>
            ';
        }
    }else{
        echo '<h4>Data tidak ditemukan...</h4>';
    }
    
}else{
    echo "<h1>Error</h1>";
}

?>