<?php
session_start();
include '../mainconfig.php';
$username = $_SESSION['username'];
$user = mysqli_query($conn, "SELECT * FROM users where username = '$username'");
$array = mysqli_fetch_array($user);

//proses order
if(isset($_POST['submit'])){
   //$pid = $_POST['pid'];
   $status = "pending";
   $jumlahpesan = $_POST['jumlah_pesan'];
   $target = $_POST['target'];
   $service_id = $_POST['service_id'];
   $totharga = $_POST['total_harga'];

   //cek service
   $cekservice = mysqli_query($conn, "SELECT * FROM service where p_id = '$service_id'");
   $resultservice = mysqli_fetch_array($cekservice);
   $min = $resultservice['min'];
   $max = $resultservice['max'];
   //cek provider
$cek = mysqli_query($conn, "SELECT * FROM provider");
$result = mysqli_fetch_array($cek);
$api_id =  $result['api_id'];
$api_key = $result['api_key'];
$api = "api_key=$api_key&api_id=$api_id&service=$service_id&target=$target&quantity=$jumlahpesan";
$url = "https://irvankedesmm.co.id/api/order";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
curl_close($curl);
$json = json_decode($result);
$hasil = $json->status;
$user_id = $array['id'];
$date = date("Y-m-d H:i:s");

if($jumlahpesan >= $min && $jumlahpesan <= $max){
   if($array['saldo'] >= $totharga){
      if($hasil == true ){
         $provider_oid = $json->data->id;
         $query =mysqli_query($conn, "INSERT INTO orderd (po_id, date, user_id, service_id, jumlah_pesan, target, total_harga, status) VALUES ('$provider_oid','$date','$user_id','$service_id','$jumlahpesan','$target','$totharga','$status')");
         if($query){
            $sukses = $json->data;
            $sisasaldo = $array['saldo'] - $totharga ;
            $update = mysqli_query($conn, "UPDATE users set saldo = '$sisasaldo' where username = '$username'");
            if($update){
               $namalayanan = $resultservice['nama'];
               $deskripsi = "melakukan pemesanan $namalayanan";
               $statuss = "ORDER";
               $saldoawal = $array['saldo'];
               $insert_log = mysqli_query($conn, "INSERT INTO log_saldo (date, nama, deskripsi, status, saldo_awal, saldo_sisa) VALUES ('$date','$username','$deskripsi','$statuss','$saldoawal','$sisasaldo')");
            }
         }
      }else{
         $error = $json->data;
      }
   }else{
      $saldokurang = "Saldo Anda tidak cukup";
   }
}else{
   $failed = "Perhatikan Minimal dan Maximal Pesanan";
}
}


?>
