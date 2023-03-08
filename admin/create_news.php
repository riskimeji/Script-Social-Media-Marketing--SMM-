<?php
$page= "News";
session_start();
include '../mainconfig.php';
if($_SESSION['level'] != 'admin'){
   header('location:../auth/sign-in.php');
}
$username = $_SESSION['username'];
$user = mysqli_query($conn, "SELECT * FROM users where username = '$username'");
$array = mysqli_fetch_array($user);
$id_user = $array['id'];
// $service = mysqli_query($conn, "SELECT * FROM service where id = '$service'")

if(isset($_POST['submit'])){
    $kategori = $_POST['kategori'];
    $desk = $_POST['deskripsi'];
    $date = date("Y-m-d H:i:s");

    $insert = mysqli_query($conn, "INSERT into news (user_id, date, kategori, deskripsi) VALUES ('$id_user','$date','$kategori','$desk')");
    if($insert){
        $msg ="ok";
        header('location:../admin/news.php');
    }
}

?>

<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Create Bank | Meji SMM</title>
      
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
                        <h4 class="card-title">Create News</h4>
                    </div>
                </div>
                <div class="card-body">
                <form method="POST" action="">
                <div class="form-group col-md-12">
                                 <label class="form-label" for="fname">Kategori:</label><br>
                                 <select name="kategori" id="" class="form-control" >
                                <option value="INFO" selected>INFO</option>
                                <option value="SERVICE">SERVICE</option>
                                <option value="WARNING">WARNING</option>
                              </select>
                                </div>
                           <div class="row">
                              <div class="form-group col-md-12">
                              <label class="form-label" for="email">Deskripsi:</label>
                           <textarea id="deskripsi" name="deskripsi" style="height:100px" class="form-control" required></textarea>
                        </div>
                              </div>
                              <button type="submit" name="submit" class="btn btn-primary">Create</button>
</div>
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
                swal("Success!", "Sukses Menambahkan Bank Baru", "success");
            </script>
      <?php
            }
      include '../admin/lib/footer.php';
      ?>
  </body>
</html>