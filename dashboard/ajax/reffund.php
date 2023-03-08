<?php
include '../../mainconfig.php';

$cekorder = mysqli_query($conn, "SELECT * FROM orderd where reffund = 0 and status = 'Error' or status = 'Partial'");
while($roworder = mysqli_fetch_array($cekorder)){
    try{
        mysqli_begin_transaction($conn);
    //cekuuser
    $cekuser = mysqli_query($conn, "SELECT * FROM users");
    $rowuser = mysqli_fetch_array($cekuser);
    //get id user
    $iduser= $rowuser['id'];
    //saldo user sebelum diref
    $saldosekarang = $rowuser['saldo'];
    //harga order
    $saldobeli = $roworder['total_harga'];
    //idorder
    $idorder = $roworder['order_id'];
    //total saldo mau direffund
    $total = $saldosekarang + $saldobeli;
    echo "Id Order: $idorder <br> Id User: $iduser <br> Saldo Sekarang: $saldosekarang <br> Saldo Reffund: $saldobeli <br> Saldo Terbaru: $total<br>";
    $reff = mysqli_query($conn, "UPDATE users set saldo = '$total' where id = '$iduser'");
 if($reff){
     $updatestatus = mysqli_query($conn, "UPDATE orderd set reffund = 1 where order_id= '$idorder'");
     if($updatestatus){
         $date = date("Y-m-d H:i:s");
         $nama = $rowuser['username'];
         $deksripsi = "reffund saldo dari transaksi partial/error dengan id: $idorder";
         $status = "REFFUND";
         $saldoawal = $saldosekarang;
         $insertlog = mysqli_query($conn, "INSERT INTO log_saldo (date, nama, deskripsi, status, saldo_awal, saldo_sisa) VALUES ('$date','$nama','$deksripsi','$status','$saldoawal', $total)");
        }
    }
    mysqli_commit($conn);
     }catch(mysqli_sql_exception $exception){
         mysqli_rollback($conn);
         throw $exception;
     }
   
}
?>