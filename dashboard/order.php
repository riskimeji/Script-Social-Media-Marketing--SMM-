<?php
$page = "Order";
session_start();
include '../mainconfig.php';
//mengambil sesion
if($_SESSION['username'] == null){
   header('location:../auth/sign-in.php');
}
$username = $_SESSION['username'];
//ngecek data user berdasarkan login
$user = mysqli_query($conn, "SELECT * FROM users where username = '$username'");
$array = mysqli_fetch_array($user);

//proses order
if(isset($_POST['submit'])){
   
   //daa untuk dikirim ketable orderd
   $status = "Pending";
   $jumlahpesan = $_POST['jumlah_pesan'];
   $target = $_POST['target'];
   $service_idp = $_POST['p_id'];
   $id_layanan = $_POST['service_id'];
   $totharga = $_POST['total_harga'];

   //cek service
   $cekservice = mysqli_query($conn, "SELECT * FROM service where p_id = '$service_idp'");
   $resultservice = mysqli_fetch_array($cekservice);
   //minimal dan pesan 
   $min = $resultservice['min'];
   $max = $resultservice['max'];
   //cek provider
   $cek = mysqli_query($conn, "SELECT * FROM provider");
   $result = mysqli_fetch_array($cek);
   $api_id =  $result['api_id'];
   $api_key = $result['api_key'];
   $api = "api_key=$api_key&api_id=$api_id&service=$service_idp&target=$target&quantity=$jumlahpesan";
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
         $name = $resultservice['nama'];
         $query =mysqli_query($conn, "INSERT INTO orderd (id_layanan, date, po_id, user_id, service_idp, jumlah_pesan, target, total_harga, status) VALUES ('$id_layanan','$date','$provider_oid','$user_id','$service_idp','$jumlahpesan','$target','$totharga','$status')");
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

<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Meji SMM | Dashboard Member</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      
      <!-- Library / Plugin Css Build -->
      <link rel="stylesheet" href="../assets/css/core/libs.min.css" />
      
      <!-- Aos Animation Css -->
      <link rel="stylesheet" href="../assets/vendor/aos/dist/aos.css" />
      
      <!-- Hope Ui Design System Css -->
      <link rel="stylesheet" href="../assets/css/hope-ui.min.css?v=1.2.0" />
      
      <!-- Custom Css -->
      <link rel="stylesheet" href="../assets/css/custom.min.css?v=1.2.0" />
      
      <!-- Dark Css -->
      <link rel="stylesheet" href="../assets/css/dark.min.css"/>
      
      <!-- Customizer Css -->
      <link rel="stylesheet" href="../assets/css/customizer.min.css" />
      
      <!-- RTL Css -->
      <link rel="stylesheet" href="../assets/css/rtl.min.css"/>
      
  </head>
  <body class="  ">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body"></div>
      </div>    </div>
    <!-- loader END -->
    <?php
    include '../dashboard/lib/sidebar.php';
    ?>  
    <main class="main-content">
    <?php
    include '../dashboard/lib/header.php';
    ?>   
<div class="conatiner-fluid content-inner mt-n5 py-0">
<div class="row">
   <div class="col-md-12 col-lg-8">
      <div class="row">
         <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="800">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Pemesanan Baru</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="" id="form">
                    <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <?php
        $query = mysqli_query($conn, "SELECT * FROM category");
        ?>
                    <select class="form-select mb-3 shadow-none" name="category" id="category" required>
                        <option selected="">Pilih salah satu kategori...</option>
                        <?php
  while($row = mysqli_fetch_array($query)){
  ?>
  <option value="<?= $row['id']?>"><?= $row['nama']?></option>
  <?php
  }
?>
                    </select>
                </div>
                        <div class="form-group">
                        <label class="form-label">Layanan</label>
                    <select class="form-select mb-3 shadow-none" name="service_id" id="layanan" required>
                        <option selected="">Pilih kategori dahulu...</option>
                    </select>
                        </div>
                        <input type="number" id ="p_id" name="p_id" hidden>
                        <div class="form-group">
                        <div class="row">
                           <div class="col">
                            <label class="form-label" for="email">Harga/1000</label>
                            <div class="input-group has-validation">
                              <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                              <input type="text" class="form-control" id="price" value="0" aria-describedby="inputGroupPrepend" readonly>
                           </div>  
                           </div>
                            <div class="col">
                            <label class="form-label" for="email">Minimal Pesan</label>
                            <input type="text" id="min" class="form-control" value="0" readonly>
                            </div>
                            <div class="col">
                            <label class="form-label" for="email">Maximal Pesan:</label>
                            <input type="text" id="max" class="form-control" value="0" readonly>
                            </div>
                            <div class="col">
                            <label class="form-label" for="email">Waktu Rata:</label>
                            <input type="text" id="average" class="form-control" value="-" readonly>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <label class="form-label" for="email">Deskripsi:</label>
                           <textarea id="deskripsi" class="form-control" readonly>-</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Target:</label>
                            <input type="text" name="target" class="form-control" id="email1" placeholder="riski.meji">
                        </div>
                        <div class="" id="deskripsi">
                        <label for=""></label>
                        </div>
                        <div class="form-group">
                        <div class="row">
                            <div class="col">
                            <label class="form-label" for="email">Jumlah Pesan:</label>
                            <input type="number" id="jumlahpesan" name="jumlah_pesan" class="form-control" placeholder="0">
                            </div>
                            <div class="col">
                            <label class="form-label" for="email">Total Harga:</label>
                            <input type="text" id="totalharga" name="total_harga" class="form-control" value="0" readonly>
                            </div>
                        </div>
                        </div>
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Pesan</button>
                    </form>
               </div>
            </div>
         </div>        
      </div>
   </div>
   <div class="col-md-12 col-lg-4">
      <div class="row">
         <div class="col-md-12 col-lg-12" id="tampil">
            <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
               <div class="card-body">
                  <div class="flex-wrap mb-4 d-flex align-itmes-center justify-content-between">
                     <!-- <div class="d-flex align-itmes-center me-0 me-md-4">
                        <div>
                           <div class="p-3 mb-2 rounded bg-soft-primary">
                              <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9303 7C16.9621 6.92913 16.977 6.85189 16.9739 6.77432H17C16.8882 4.10591 14.6849 2 12.0049 2C9.325 2 7.12172 4.10591 7.00989 6.77432C6.9967 6.84898 6.9967 6.92535 7.00989 7H6.93171C5.65022 7 4.28034 7.84597 3.88264 10.1201L3.1049 16.3147C2.46858 20.8629 4.81062 22 7.86853 22H16.1585C19.2075 22 21.4789 20.3535 20.9133 16.3147L20.1444 10.1201C19.676 7.90964 18.3503 7 17.0865 7H16.9303ZM15.4932 7C15.4654 6.92794 15.4506 6.85153 15.4497 6.77432C15.4497 4.85682 13.8899 3.30238 11.9657 3.30238C10.0416 3.30238 8.48184 4.85682 8.48184 6.77432C8.49502 6.84898 8.49502 6.92535 8.48184 7H15.4932ZM9.097 12.1486C8.60889 12.1486 8.21321 11.7413 8.21321 11.2389C8.21321 10.7366 8.60889 10.3293 9.097 10.3293C9.5851 10.3293 9.98079 10.7366 9.98079 11.2389C9.98079 11.7413 9.5851 12.1486 9.097 12.1486ZM14.002 11.2389C14.002 11.7413 14.3977 12.1486 14.8858 12.1486C15.3739 12.1486 15.7696 11.7413 15.7696 11.2389C15.7696 10.7366 15.3739 10.3293 14.8858 10.3293C14.3977 10.3293 14.002 10.7366 14.002 11.2389Z" fill="currentColor"></path>                                            
                              </svg>
                           </div>
                        </div>
                        <div class="ms-3">
                           <h5>1153</h5>
                           <small class="mb-0">Products</small>
                        </div>
                     </div> -->
                     <div class="d-flex align-itmes-center">
                        <div>
                           <div class="p-3 mb-2 rounded bg-soft-info">
                              <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1213 11.2331H16.8891C17.3088 11.2331 17.6386 10.8861 17.6386 10.4677C17.6386 10.0391 17.3088 9.70236 16.8891 9.70236H14.1213C13.7016 9.70236 13.3719 10.0391 13.3719 10.4677C13.3719 10.8861 13.7016 11.2331 14.1213 11.2331ZM20.1766 5.92749C20.7861 5.92749 21.1858 6.1418 21.5855 6.61123C21.9852 7.08067 22.0551 7.7542 21.9652 8.36549L21.0159 15.06C20.8361 16.3469 19.7569 17.2949 18.4879 17.2949H7.58639C6.25742 17.2949 5.15828 16.255 5.04837 14.908L4.12908 3.7834L2.62026 3.51807C2.22057 3.44664 1.94079 3.04864 2.01073 2.64043C2.08068 2.22305 2.47038 1.94649 2.88006 2.00874L5.2632 2.3751C5.60293 2.43735 5.85274 2.72207 5.88272 3.06905L6.07257 5.35499C6.10254 5.68257 6.36234 5.92749 6.68209 5.92749H20.1766ZM7.42631 18.9079C6.58697 18.9079 5.9075 19.6018 5.9075 20.459C5.9075 21.3061 6.58697 22 7.42631 22C8.25567 22 8.93514 21.3061 8.93514 20.459C8.93514 19.6018 8.25567 18.9079 7.42631 18.9079ZM18.6676 18.9079C17.8282 18.9079 17.1487 19.6018 17.1487 20.459C17.1487 21.3061 17.8282 22 18.6676 22C19.4969 22 20.1764 21.3061 20.1764 20.459C20.1764 19.6018 19.4969 18.9079 18.6676 18.9079Z" fill="currentColor"></path>                                            
                              </svg>                                        
                           </div>
                        </div>
                        <div class="ms-3">
                        <?php
                        $iduser = $array['id'];
                        $order = mysqli_query($conn, "SELECT * FROM orderd where user_id = $iduser and DATE(date) = DATE(NOW())");
                        $hitung = mysqli_num_rows($order);
                        ?>
                           <h5><?php echo $hitung?></h5>
                           <small class="mb-0">Order Today</small>
                        </div>
                     </div>
                  </div>
                  <div class="mb-4">
                     <div class="flex-wrap d-flex justify-content-between">
                        <h2 class="mb-2"><?php echo "Rp " . number_format($array['saldo'],2,',','.');?></h2>
                     </div>
                     <p class="text-info">Total Saldo</p>
                  </div>
                  <div class="grid-cols-2 d-grid gap-card">
                     <button class="p-2 btn btn-primary text-uppercase">Deposit</button>
                     <button class="p-2 btn btn-info text-uppercase"><a href="../dashboard/history_saldo.php" class="text-white">History</a></button>
                  </div>
               </div>
            </div>
         </div>
         <!-- <div class="col-md-12 col-lg-12">
            <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
               <div class="card-body">
                  <div class="header-title">
                        <h4 class="card-title">Informasi</h4>
                  </div>
                  <label for="">Langkah - Langkah Membuat Pesenan</label>
                  <p>
                  1. Pilih salah satu Kategori. <br>
                  2. Pilih salah satu Layanan yang ingin dipesan. <br>
                  3. Masukkan Target pesanan sesuai ketentuan yang diberikan layanan tersebut. <br>
                  4. Masukkan Jumlah Pesanan yang diinginkan. <br>
                  5. Klik Submit untuk membuat pesanan baru. <br>
                  </p>
               </div>
            </div>
         </div> -->
      </div>
   </div> 
   <div class="col-md-12 col-lg-12">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
               <div class="card-body">
                  <div class="header-title">
                        <h4 class="card-title">Informasi</h4>
                    </div>
                    
                       <label for="">Langkah - Langkah Membuat Pesenan</label>
                       <ul>
                       <li>Pilih salah satu Kategori.</li>
                        <li>salah satu Layanan yang ingin dipesan</li>
                        <li>Masukkan Target pesanan sesuai ketentuan yang diberikan layanan tersebut</li>
                        <li>Masukkan Jumlah Pesanan yang diinginkan</li>
                        <li>Klik Submit untuk membuat pesanan baru</li>
                     </ul>
                  <label class="mt-2 "for="">Ketentuan membuat pesanan baru:</label>
                  <ul>
                        <li>Silahkan membuat pesanan sesuai langkah-langkah diatas</li>
                        <li>Jika ingin membuat pesanan dengan Target yang sama dengan pesanan yang sudah pernah dipesan sebelumnya, mohon menunggu sampai pesanan sebelumnya selesai diproses</li>
                        <li>Jika terjadi kesalahan / mendapatkan pesan gagal yang kurang jelas, silahkan hubungi Admin untuk informasi lebih lanjut.</li>
                     </ul>
               </div>
            </div>
         </div>
      </div>
   </div> 
</div>
      </div>
      <script src="../assets/jquery-3.6.3.min.js"></script>
    <script>
      $(document).ready(function(){
        $('#category').on('change', function(){
            var id = $(this).val();
            if(id){
                $.get(
                    "ajax/order.php",
                    {category: id},
                    function(data){
                        $('#layanan').html(data);
                    }
                );
            }else{
                $("#layanan").html('<option>==Pilih Layanan Terlebih Dahulu==</option>')
            }
            $.ajax({
                url : "ajax/detailorder.php",
                data: "id=" + id,
                method: "post",
                dataType: 'json',
                success: function(data){
                    $("#price").val(data.harga);
                }
            })
            $.ajax({
                url : "ajax/detailorder.php",
                data: "id=" + id,
                method: "post",
                dataType: 'json',
                success: function(data){
                    $("#min").val(data.min);
                }
            })
            $.ajax({
                url : "ajax/detailorder.php",
                data: "id=" + id,
                method: "post",
                dataType: 'json',
                success: function(data){
                    $("#max").val(data.max);
                }
            })
            $.ajax({
                url : "ajax/detailorder.php",
                data: "id=" + id,
                method: "post",
                dataType: 'json',
                success: function(data){
                    $("#average").val(data.est_masuk);
                }
            })
            $.ajax({
                url : "ajax/detailorder.php",
                data: "id=" + id,
                method: "post",
                dataType: 'json',
                success: function(data){
                    $("#layanan").val(data.id);
                }
            })
            $.ajax({
                url : "ajax/detailorder.php",
                data: "id=" + id,
                method: "post",
                dataType: 'json',
                success: function(data){
                    $("#p_id").val(data.p_id);
                }
            })
            $.ajax({
                url : "ajax/detailorder.php",
                data: "id=" + id,
                method: "post",
                dataType: 'json',
                success: function(data){
                    $("#deskripsi").val(data.deskripsi);
                }
            })
        });
      });
    </script>
    <script type="text/javascript">
       $("#jumlahpesan").keyup(function(){
         var jumlahpesan = parseInt($("#jumlahpesan").val());
         var harga = parseInt($("#price").val());
         var total = jumlahpesan * harga / 1000;
         
         if(total == false){
            $("#totalharga").val(0);
         }else{
            $("#totalharga").val(total);
         }
        });
    </script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
   <?php
    if(isset($error)){
      $hasil = $json->data
    ?>
            <script>
                swal("Error!", "<?php echo $hasil; ?>", "error");
            </script>
            <?php
    }
    if(isset($sukses)){
            ?>
             <script>
                swal("Sukses!", "Sukses melakukan pesanan", "success");
            </script>
            <?php
    }
    if(isset($failed)){
    ?>
     <script>
                 swal("Error!", "<?php echo $failed; ?>", "error");
             </script>
    <?php
    }if(isset($saldokurang)){
    ?>
    <script>
                 swal("Error!", "<?php echo $saldokurang; ?>", "error");
             </script>
             <?php
             }
             ?>
       <!-- <script>
         $(document).ready(function(){
            $('#submit').on('click', function(){
               $('#submit').load("order.php");
            })
         })
       </script> -->
      <?php
    
      include '../dashboard/lib/footer.php';
      ?>
  </body>
</html>