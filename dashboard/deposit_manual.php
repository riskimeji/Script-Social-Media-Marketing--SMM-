<?php
$page = "Deposit";
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
  $user_id = $array['id'];
  $bank_id = $_POST['bank']; 
  $jumlahdepo = $_POST['total_deposit']; 
  $totaldapat = $_POST['total_didapat']; 
  $status = "PENDING";
  $lokasi = "assets/buktitf/";
  $gambar = $_FILES['bukti_tf']['name'];
  $date = date("Y-m-d H:i:s");
  $file_tmp = $_FILES['bukti_tf']['tmp_name'];
  $target_file = $lokasi . basename($_FILES["bukti_tf"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["bukti_tf"]["tmp_name"]);
  if($check !== false) {
    move_uploaded_file($file_tmp, '../assets/buktitf/'.$gambar);
    $insert = mysqli_query($conn, "INSERT INTO deposit (date, bank_id, user_id, jumlah_deposit, total_didapat, bukti_tf, status) VALUES ('$date','$bank_id', '$user_id','$jumlahdepo','$totaldapat','$gambar','$status')");
    if($insert){
        $uploadOk = 1;
    }
  } else {
    $uploadNotOk = 0;
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
                        <h4 class="card-title">Deposit Manual</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="" id="form" enctype="multipart/form-data">
                    <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <?php
        $query = mysqli_query($conn, "SELECT * FROM bank");
        ?>
                    <select class="form-select mb-3 shadow-none" name="bank" id="bank" required>
                        <option selected="">Pilih salah satu kategori...</option>
                        <?php
  while($row = mysqli_fetch_array($query)){
  ?>
  <option value="<?= $row['id']?>"><?= $row['jenis'] ?> - <?= $row['nama'] ?> - <?= $row['norek'] ?> [MANUAL]  </option>
  <?php
  }
?>
                    </select>
                </div>
                        <div class="form-group">
                        <label class="form-label" for="email">Deskripsi:</label>
                           <textarea id="deskripsi" style="height:100px" class="form-control" readonly>-</textarea>
                        </div>
                        <div class="form-group">
                        <div class="row">
                            <div class="col">
                            <label class="form-label" for="email">Jumlah Deposit:</label>
                            <input type="number" id="jumlahdepo" name="total_deposit" class="form-control" placeholder="0" required>
                            </div>
                            <div class="col">
                            <label class="form-label" for="email">Total Didapat:</label>
                            <input type="text" id="totaldidapat" name="total_didapat" class="form-control" value="0" readonly>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="customFile" class="form-label custom-file-input">Bukti Transfer</label>
                            <input class="form-control" accept="image/png, image/jpg, image/jpeg"  name="bukti_tf" type="file" id="customFile" required>
                        </div>
                        </div>
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Deposit</button>
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
                    
                       <label for="">Langkah - Langkah Membuat Deposit Manual</label>
                       <ul>
                       <li>Pilih salah satu Bank.</li>
                        <li>Masukkan Jumlah Total Deposit</li>
                        <li>Lakukan Transfer Sesuai dengan Nominal Jumlah Deposit</li>
                        <li>Klik Submit untuk membuat Deposit</li>
                        <li>Tunggu Hingga Admin selesai Melakukan Validasi</li>
                     </ul>
                  <label class="mt-2 "for="">Ketentuan membuat Deposit Baru:</label>
                  <ul>
                        <li>Minimal Deposit adalah Rp 20.000,00.</li>
                     </ul>
               </div>
            </div>
         </div>
      </div>
   </div> 
</div>
      </div>
      <script src="../assets/jquery-3.6.3.min.js"></script>
    <script type="text/javascript">
       $("#jumlahdepo").keyup(function(){
         var jumlahdepo = parseInt($("#jumlahdepo").val());
         var total = jumlahdepo;
         if(total == false){
            $("#totaldidapat").val(0);
         }else{
            $("#totaldidapat").val(total);
         }
        });
    </script>
    <script>
              $(document).ready(function(){
                $("#bank").on('change', function(){
                  /*
                              // var desk = "Silahkan Lakukan Transfer ke <?php echo $row['jenis']?> Atas Nama <?php echo $row['nama']?> dengan No Rek <?php echo $row['norek']; ?>, nominal sesuai dengan Jumlah Deposit Anda lalu upload bukti transfer.";
                  */
            var desk = "Silahkan Lakukan Transfer ke Rekening yang Anda pilih, nominal sesuai dengan Jumlah Deposit Anda lalu upload bukti transfer.";
            $("#deskripsi").val(desk);
        })
            })
    </script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
   <?php
   
    if(isset($uploadNotOk)){
    ?>
            <script>
                swal("Error!", "Upload Gambar Yang Benar", "error");
            </script>
            <?php
    }
    if(isset($uploadOk)){
            ?>
             <script>
                swal("Sukses!", "Deposit Sedang di Proses", "success");
            </script>
            <?php
    }
    ?>
      <?php
    
      include '../dashboard/lib/footer.php';
      ?>
  </body>
</html>