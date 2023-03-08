<?php
session_start();
include '../mainconfig.php';
if($_SESSION['level'] != 'member'){
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
      <title>Riwayat Depsoit | Meji SMM</title>
      
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
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Deposit Member</h4>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="test" class="table table-striped" data-toggle="data-table">
                     <thead>
                        <tr>
                           <th>ID Deposit</th>
                           <th>Date</th>
                           <th>Bank Id</th>
                           <th>Jumlah Deposit</th>
                           <th>Total di Dapat</th>
                           <th>Bukti Tf</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                     $data = mysqli_query($conn, "SELECT * FROM deposit where user_id = '$id_user'");
                    while($row = mysqli_fetch_array($data)){
                        ?>
                        <tr>
                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['date']?></td>
                        <td><?php echo $row['bank_id']?></td>
                        <td><?php echo "Rp " . number_format($row['jumlah_deposit'],2,',','.');?></td>
                        <td><?php echo "Rp " . number_format($row['total_didapat'],2,',','.');?></td>
                        <td><img width="50" height="50" src="../assets/buktitf/<?php echo $row['bukti_tf']?>" alt=""></td>
<?php
                        if($row['status'] == "PENDING" ){
                        ?>
                        <td style="color:orange"><?php echo $row['status']?></td>
                        <?php
                        }elseif($row['status'] == "Processing"){
                        ?>
                        <td style="color:blue"><?php echo $row['status']?></td>
                        <?php
                        }else{                        
                        ?>
                        <td><?php echo $row['status']?></td>    
                        <?php
                        }
                        ?>                     
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
     include '../dashboard/lib/footer.php';
      ?>
  </body>
</html>