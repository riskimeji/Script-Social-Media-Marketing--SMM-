<?php
$page= "Deposit";
session_start();
include '../mainconfig.php';
if($_SESSION['level'] != 'admin'){
   header('location:../auth/sign-in.php');
}
$username = $_SESSION['username'];


$id = $_GET['id'];
if($id == null){
    header('location:../admin/index.php');
}
    $depo = mysqli_query($conn, "SELECT * FROM deposit where id = '$id'");
    $array = mysqli_fetch_array($depo);
    $user_id = $array['user_id'];
    $totaldidapat = $array['total_didapat'];

    $cekuser = mysqli_query($conn, "SELECT * FROM users where id = '$user_id'");
    $arrayuser = mysqli_fetch_array($cekuser);
    $currentsaldo = $arrayuser['saldo'];

    $total_saldo = $totaldidapat + $currentsaldo;
    if(isset($_POST['submit'])){
        $status = $_POST['status'];
        if($status == "SUCCESS"){
            $update = mysqli_query($conn, "UPDATE deposit set status = '$status' where id = '$id'");
        if($update){
            $update_saldo = mysqli_query($conn, "UPDATE users set saldo = '$total_saldo' where id = '$user_id'");
            if($update_saldo){
                $date = date("Y-m-d H:i:s");
                $nama = $arrayuser['username'];
                $desk = "Melakukan Deposit dengan ID: $id";
                $statuss ="DEPOSIT MANUAL";
                $insertlog = mysqli_query($conn, "INSERT INTO log_saldo (date, nama, deskripsi, status, saldo_awal, saldo_sisa) VALUES ('$date','$nama','$desk','$statuss','$currentsaldo','$total_saldo')");
            }
            $msg ="ok";
            header('location:../admin/deposit.php');
        }
        }else{
            $update = mysqli_query($conn, "UPDATE deposit set status = '$status' where id = '$id'");
            header('location:../admin/deposit.php');
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
    include '../admin/lib/sidebar.php';
    ?>  
    <main class="main-content">
    <?php
    include '../admin/lib/header.php';
    ?>   
<div class="conatiner-fluid content-inner mt-n5 py-0">
<div class="row">
   <div class="col-md-12 col-lg-12">
      <div class="row">
         <div class="col-md-12">
            <div class="card" data-aos="fade-up" data-aos-delay="800">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Deposit</h4>
                    </div>
                </div>
                <div class="card-body">
                <form method="POST" action="">
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="fname">Jumlah Deposit:</label>
                                 <input type="text" class="form-control" name="jumlah_deposit" value="<?php echo "Rp " . number_format($array['jumlah_deposit'],2,',','.');?>" id="fname" placeholder="Nama Bank" required disabled>
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="lname">Total Didapat:</label>
                                 <input type="text" class="form-control" name="jumlah_didapat" value="<?php echo "Rp " . number_format($array['total_didapat'],2,',','.');?>" id="lname" placeholder="Norek" required disabled>
                              </div>
</div>
                            <div class="form-group col-md-6">
                                 <label class="form-label" for="fname">Jumlah Deposit:</label><br>
                                 <img src="../assets/buktitf/<?php echo $array['bukti_tf']?>" alt="" width="300px" height="400px">
                              </div>

                              <div class="form-group col-md-6">
                                 <label class="form-label" for="fname">Status:</label><br>
                                 <select name="status" id="" class="form-control" >
                                    <?php
                                    if($array['status'] == "PENDING"){
                                    ?>
                                <option value="<?php $array['status']?>" selected><?php echo $array['status']?></option>
                                <option value="DITOLAK">DITOLAK</option>
                                <option value="SUCCESS">SUCCESS</option>
                            <?php
                                    }else{

                            ?>
                            <p>Deposit Sudah diubah</p>
<?php
                                    }
?>                            
                              </select>
                             
                                </div>
                            
                           <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </form>
               </div>
            </div>
         </div>        
      </div>
   </div>
</div>
      </div>
      <script src="../assets/jquery-3.6.3.min.js"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
   <?php
    if(isset($msg)){
    ?>
            <script>
                swal("Success!", "Sukses Edit Data", "success");
            </script>
      <?php
            }
      include '../admin/lib/footer.php';
      ?>
  </body>
</html>