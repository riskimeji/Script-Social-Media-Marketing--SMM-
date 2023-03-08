<?php
include '../mainconfig.php';
//hide error
ini_set('display_errors', 0);
session_start();
if($_SESSION['status'] == "login"){
    header('location:../dashboard/index.php');
}
if(isset($_POST['submit'])){
    //post
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $level = "member";
    $saldo = 0;
    //cek username
    $cekusername = mysqli_query($conn, "SELECT * from users where username = '$username'");
    $cekusernamerow = mysqli_num_rows($cekusername);
    if($cekusernamerow < 1){
        //cek email
        $cekemail = mysqli_query($conn, "SELECT * from users where email = '$email'");
        $cekemailrow= mysqli_num_rows($cekemail);
        if($cekemailrow < 1){                
                if($password == $confirmpassword){
                    $pwmd = md5($password);
                    $insertuser = mysqli_query($conn, "INSERT INTO users (first_name, last_name, username, email, phone, password, level, saldo) VALUES ('$first_name','$last_name','$username','$email','$phone','$pwmd','$level','$saldo')");
                    if($insertuser){
                        $message ="success";
                    }
                }else{
                    $message = "errorpw";
                }
        }else{
                $message  = "emailalready";
            }
    }else{
            $message = "useralready";
        }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        body {
            background-color: darkcyan;
        }
        
        .box-custom {
            height: 580px;
            width: 500px;
            margin: auto;
            position: absolute;
            background-color: white;
            border-radius: 10px;
            top: 0;
            left: 0px;
            bottom: 0;
            right: 0px;
            /* padding-left: 20px; */
            /* padding-block-start: 20px; */
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
        <h3 class="d-flex justify-content-center mt-4">Sign Up</h3>
        <div class="">
        </div>
        <div class="ms-4 me-4 mt-3">
            <div class="row">
                <div class="col">
                    <label for="" class="text-black mb-1">First Name</label>
                    <input type="text" name="first_name" class="form-control" required placeholder="first name">
                </div>
                <div class="col">
                    <label for="" class="text-black mb-1">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required placeholder="last name">
                </div>
            </div>
        </div>
        <div class="ms-4 me-4 mt-2">
            <label for="" class="text-black mb-1">Username</label>
            <input type="text" name="username" class="form-control" placeholder="username" required>
        </div>
        <div class="ms-4 me-4 mt-2">
            <label for="" class="text-black mb-1">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="email@gmail.com">
        </div>
        <div class="ms-4 me-4 mt-2">
            <label for="" class="text-black mb-1">Phone Number</label>
            <input type="number" name="phone" class="form-control" required placeholder="08xxxxx">
        </div>
        <div class="ms-4 me-4 mt-2">
            <div class="row">
                <div class="col">
                    <label for="" class="text-black mb-1">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="password">
                </div>
                <div class="col">
                    <label for="" class="text-black mb-1">Confirmation Password</label>
                    <input type="password" name="confirmpassword" class="form-control" required placeholder="confirmation password">
                </div>
            </div>
        </div>
        <div class="form-check ms-4 mt-2">
            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" required>I agree with the terms of use
        </div>
        <div class="d-flex justify-content-center">
            <input type="submit" name="submit" value="REGISTER" style="width: 450px;" class="btn btn-primary mt-2">
        </div>
        <div class="ms-4 mt-2">
            <label for="">Already have account?</label><a href="../auth/sign-in.php">Sign in</a>
        </div>
    </div>
    </form>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <?php
    if($message == "errorpw"){
    ?>
            <script>
                swal("Error!", "Password harus sama!", "error");
            </script>
            <?php
    }elseif($message == "emailalready"){
            ?>
            <script>
                swal("Error!", "Email sudah digunakan!", "error");
            </script>
            <?php
    }elseif($message == "useralready"){
            ?>
    <script>
    swal("Error!", "Username sudah digunakan!", "error");
    </script>
            <?php
    }elseif($message == "success"){
            ?>
    <script>
   swal({
    title: "Success!",
    text: "Sukses Mendaftar!",
    type: "success"
}).then(function() {
    window.location = "../auth/sign-in.php";
});
    </script>
    <?php
    }?>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>