<?php
include '../mainconfig.php';
ini_set('display_errors', 0);
session_start();
if($_SESSION['status'] == "login"){
    header('location:../admin/index.php');
}
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = mysqli_query($conn, "SELECT * FROM users where username='$username' and password='$password' and level = 'admin'");
    $ceklevel = mysqli_fetch_array($query);
$cek = mysqli_num_rows($query);
if($cek > 0){
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['level'] = $ceklevel['level'];
    $_SESSION['status'] = "login";
    header ('location:../admin/index.php');
}else{
    $message = "failed";
}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        body {
            background-color: darkcyan;
        }
        .box-custom {
            height: 310px;
            width: 500px;
            margin: auto;
            position: absolute;
            background-color: white;
            border-radius: 10px;
            top: 0;
            left: 0px;
            bottom: 0;
            right: 0px;
            box-shadow: 10px 5px 5px rgba(0, 0, 0, 0.562);
        }
        
        .line {
            height: 2px;
            background-color: gray;
            width: 500px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
    <div class="box-custom">
        <h3 class="d-flex justify-content-center mt-4">Sign in</h3>
        <div class="">
        </div>
        <div class="ms-4 me-4 mt-3">
            <label for="" class="text-black mb-1">Username</label>
            <input type="text" name="username" class="form-control" placeholder="username">
        </div>
        <div class="ms-4 me-4 mt-2">
            <label for="" class="text-black mb-1">Password</label>
            <input type="password" name="password" class="form-control" placeholder="password">
        </div>
        <div class="d-flex justify-content-center mt-2">
            <input type="submit" name="submit" value="SIGN IN" style="width: 450px;" class="btn btn-primary mt-2">
        </div>
    </div>
    </form>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    if($message){
    ?>
    <script>
                swal("Error!", "Username & Password Salah!", "error");
            </script>
    <?php
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>