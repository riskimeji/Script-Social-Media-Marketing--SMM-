<?php
/*
Created By: Ahmad Rizki Akbar Ganiyu(mejixx)
Copyright 2023
*/

//koneksi database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'mejixxmy_panel');
define('DB_PASSWORD', 'mejixxmy_panel');
define('DB_DATABASE', 'mejixxmy_panel');

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if($conn){
}else{
    echo mysqli_connect_errno();
}
?>