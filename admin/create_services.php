<?php
$page= "Layanan";
session_start();
include '../mainconfig.php';
//mengambil sesion
if($_SESSION['level'] != "admin"){
   header('location:../auth/sign-in.php');
}

if(isset($_POST['submit'])){

   $kategori = $_POST['category'];
   $nama = $_POST['nama'];
   $desk = $_POST['deskripsi'];
   $p_id = $_POST['p_id'];
   $status = $_POST['status'];
   $harga = $_POST['harga'];
   $min = $_POST['min'];
   $max = $_POST['max'];
   $est = $_POST['est_masuk'];
   
   $insert = mysqli_query($conn, "INSERT INTO service (category, p_id, nama, deskripsi, min, max, est_masuk, harga, status) VALUES ('$kategori','$p_id','$nama','$desk','$min','$max','$est','$harga','$status')");
   if($insert){
    header('location:../admin/services.php');
   }
   
}


?>

<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Create Service | Meji SMM</title>
      
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
                        <h4 class="card-title">Service Baru</h4>
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
                            <label class="form-label" for="email">Nama:</label>
                            <input type="text" name="nama" class="form-control" id="email1" placeholder="nama layanan.." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Provider ID:</label>
                            <input type="number" name="p_id" class="form-control" id="email1" placeholder="1234" required>
                        </div>
                        <div class="form-group">
                        <div class="row">
                           <div class="col">
                            <label class="form-label" for="email">Harga/1000</label>
                            <div class="input-group has-validation">
                              <span class="input-group-text" id="inputGroupPrepend">Rp</span>
                              <input type="number" name="harga" class="form-control" id="price" placeholder="0" aria-describedby="inputGroupPrepend" required>
                           </div>  
                           </div>
                            <div class="col">
                            <label class="form-label" for="email">Minimal Pesan</label>
                            <input type="number" id="min" name="min" class="form-control" placeholder="0" required>
                            </div>
                            <div class="col">
                            <label class="form-label" for="email">Maximal Pesan:</label>
                            <input type="number" id="max" name="max" class="form-control" placeholder="0" required>
                            </div>
                            <div class="col">
                            <label class="form-label" for="email">Waktu Rata:</label>
                            <input type="text" id="average" name="est_masuk" class="form-control" required>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <label class="form-label" for="email">Deskripsi:</label>
                           <textarea id="deskripsi" name="deskripsi" class="form-control" required>-</textarea>
                        </div>
                        <div class="form-group">
                                 <label class="form-label" for="fname">Status:</label><br>
                                 <select name="status" id="" class="form-control" >
                                <option value="aktif" selected>Aktif</option>
                                <option value="non">Non-Aktif</option>
                              </select>
                                </div>
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
                    </form>
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
    
      include '../admin/lib/footer.php';
      ?>
  </body>
</html>