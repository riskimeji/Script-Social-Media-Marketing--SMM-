<?php
session_start();
include '../mainconfig.php';
if($_SESSION['level'] != 'admin'){
   header('location:../auth/sign-in.php');
}
$username = $_SESSION['username'];
//ngecek data user berdasarkan login
$user = mysqli_query($conn, "SELECT * FROM users where username = '$username'");
$array = mysqli_fetch_array($user);
$user_id = $array['id'];

if(isset($_POST['submit'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $newpassword = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $current_password = md5($_POST['current_password']);
    $passwordsekarang = $array['password'];

    if($current_password == null){
        $query = mysqli_query($conn, "UPDATE users set first_name = '$first_name', last_name = '$last_name', phone = '$phone'");
        if($query){
            $pesan = "Sukses Melakukan Update";
        }
    }elseif($current_password == $passwordsekarang){
        if($newpassword == $confirm){
            $pwmd = md5($newpassword);
            $update = mysqli_query($conn, "UPDATE users set first_name = '$first_name', last_name = '$last_name', phone = '$phone', password = '$pwmd' where id ='$user_id'");
            if($update){
            $pesan ="Sukses Melakukan Update";
            }
        }else{
            $error = "Password Tidak Sama"; 
        }
    }else{
        $msgerror = "Password Saat Ini Salah";
    }
}

?>

<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Profile | Meji SMM</title>
      
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
                        <h4 class="card-title">Profile</h4>
                    </div>
                </div>
                <div class="card-body">
                <form method="POST" action="">
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="fname">First Name:</label>
                                 <input type="text" class="form-control" name="first_name" value ="<?php echo $array['first_name'] ?>" id="fname" placeholder="First Name" required>
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="lname">Last Name:</label>
                                 <input type="text" class="form-control" name="last_name" value ="<?php echo $array['last_name'] ?> " id="lname" placeholder="Last Name" required>
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="add1">Phone :</label>
                                 <input type="text" class="form-control" name="phone" id="add1" value="<?php echo $array['phone'] ?>" placeholder="Phone" required>
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="add2">Email:</label>
                                 <input type="text" class="form-control" name="email" value="<?php echo $array['email'] ?>" id="add2" disabled>
                              </div>
                           </div>
                           <hr>
                           <h5 class="mb-3">Security</h5>
                           <div class="row">
                              <div class="form-group col-md-12">
                                 <label class="form-label" for="uname">User Name:</label>
                                 <input type="text" class="form-control" name="username" value="<?php echo $array['username'] ?>" id="uname" disabled>
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="pass">New Password:</label>
                                 <input type="password" class="form-control" name="password" id="pass" placeholder="Password" >
                                 <p style="font-size:13px; color:red;">*Kosongkan jika tidak ingin mengubah kata sandi</p>
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="rpass">New Repeat Password:</label>
                                 <input type="password" class="form-control" name="confirm_password" id="rpass" placeholder="Repeat Password">
                                 <p style="font-size:13px; color:red;">*Kosongkan jika tidak ingin mengubah kata sandi</p>
                              </div>
                              <div class="form-group col-md-12">
                                 <label class="form-label" for="uname">Current Password:</label>
                                 <input type="password" class="form-control" name="current_password" id="uname" placeholder="Current Password">
                                 <p style="font-size:13px; color:red;">*Isi jika tidak ingin mengubah kata sandi</p>
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
    if(isset($error)){
    ?>
            <script>
                swal("Error!", "<?php echo $error ?>", "error");
            </script>
            <?php
    }
    if(isset($pesan)){
            ?>
             <script>
                swal("Sukses!", "<?php echo $pesan ?>", "success");
            </script>
            <?php
            }elseif(isset($msgerror)){
                ?>
                        <script>
                swal("Error!", "<?php echo $msgerror ?>", "error");
            </script>
      <?php
            }
      include '../admin/lib/footer.php';
      ?>
  </body>
</html>