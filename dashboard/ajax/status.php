<?php
include '../../mainconfig.php';
$query = mysqli_query($conn, "SELECT po_id FROM orderd where status != 'Success'");
   //cek provider
   $cek = mysqli_query($conn, "SELECT * FROM provider");
   $result = mysqli_fetch_array($cek);
   $api_id =  $result['api_id'];
   $api_key = $result['api_key'];
   $url = "https://irvankedesmm.co.id/api/status";
while($row = mysqli_fetch_array($query)){
    $id = $row['po_id'];
    $api = "api_key=$api_key&api_id=$api_id&id=$id";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $api);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $json = json_decode($result);
    $hasil = $json->status;
    if($hasil == 1){
        $status= $json->data->status;
        $update = mysqli_query($conn, "UPDATE orderd set status = '$status'");   
     }
}
?>