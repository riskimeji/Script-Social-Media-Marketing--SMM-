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
    $user = mysqli_query($conn, "SELECT * FROM provider where id = '$id'");
    $array = mysqli_fetch_array($user);
    if(isset($_POST['submit'])){
        $jenis = $_POST['nama'];
        $nama = $_POST['api_id'];
        $norek = $_POST['api_key'];
        $update = mysqli_query($conn, "UPDATE provider set nama = '$jenis', api_id= '$nama', api_key='$norek' where id = '$id'");
        if($update){
            $msg ="ok";
            header('location:../admin/provider.php');
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
                        <h4 class="card-title">Edit Provider</h4>
                    </div>
                </div>
                <div class="card-body">
                <form method="POST" action="">
                <div class="form-group col-md-12">
                                 <label class="form-label" for="fname">Nama :</label>
                                 <input type="text" class="form-control" value="<?php echo $array['nama']?>" name="nama" id="fname" placeholder="Nama Bank" required>
                              </div>
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="fname">Api ID:</label>
                                 <input type="text" class="form-control" name="nama" value="<?php echo $array['api_id']?>" id="fname" placeholder="Nama Bank" required>
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="lname">Api Key:</label>
                                 <input type="text" class="form-control" name="norek" value="<?php echo $array['api_key']?>" id="lname" placeholder="Norek" required>
                              </div>
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