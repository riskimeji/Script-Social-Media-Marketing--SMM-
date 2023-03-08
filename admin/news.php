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

?>

<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>News | Meji SMM</title>
      
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
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
               <div class="header-title">
                <div class="d-flex">
                    <h4 class="card-title p-2">News</h4>
                    <button class="btn btn-primary ms-auto"><a href="../admin/create_news.php" class="text-white">CREATE</a></button>
                </div>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="test" class="table table-striped" data-toggle="data-table">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Date</th>
                           <th>Kategori</th>
                           <th>Deskripsi</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                     $no = 1;
                     $data = mysqli_query($conn, "SELECT * FROM news");
                    while($row = mysqli_fetch_array($data)){
                        ?>
                        <tr>
                        <td><?php echo $no++;?></td>
                        <td><?php echo $row['date']?></td>
                        <td><?php echo $row['kategori']?></td>
                        <td><?php echo $row['deskripsi']?></td>
                        <td><button class="btn btn-warning" ><a href="../admin/edit_news.php?id=<?php echo $row['id']?>" class="text-white">Edit</a></button> <button class="btn btn-danger"><a href="../admin/delete_news.php?id=<?php echo $row['id']?>" class="text-white">Delete</a></button></td>
                        </tr>
                        <?php  
                    }
                        ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
      </div>
      <script src="../assets/jquery-3.6.3.min.js"></script> 
      <?php
     include '../admin/lib/footer.php';
      ?>
  </body>
</html>