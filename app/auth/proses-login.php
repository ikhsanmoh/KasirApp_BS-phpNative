<?php 

  // Mengambil Base URL
  include "../../config/url-base.php";
  
  // Memulai Session
  session_start(); 
  
  // Memanggil Koneksi
  require "../../config/koneksi.php";

  if ( isset($_POST['login_form']) ) {
    
    $username = $_POST['username'];
    $pass = md5($_POST['password']);

    // Query untuk mengecek username
    $query = "SELECT * FROM tb_users WHERE email LIKE '$username'";
    
    // Eksekusi Query
    $sql = mysqli_query($koneksi, $query);
    
    // Fetch data berdasarkan nama kolom
    $data = mysqli_fetch_assoc($sql);

    // Validasi Username
    if ( mysqli_num_rows($sql) != 0 ) {
      
      // Validasi Password
      if ( $pass == $data['pass'] ) {
        
        // Men-Set Session User ID (Untuk Keperluan CRUD)
        $_SESSION['user_id'] = $data['id'];
        // Men-Set User (Untuk Keperluan Authentication & Authorization)
        $_SESSION['user'] = $data['nama'];
        // Men-Set Session Time (Untuk Keperluan Login Timeout)
        // $_SESSION['login_time'] = time();
        header('location: '. $base . 'app/auth/login.php');
      
      } else {
        
        // Redirect dengan status kesalahan Password
        header('location: '. $base .'app/auth/login.php?status=err_pass');
      
      }
      
    } else {
      
      // Redirect dengan status kesalahan Username 
      header('location: '. $base .'app/auth/login.php?status=err_usernm');

    }

  } else {

    // Redirect untuk URL Protection
    header('location: '. $base .'app/auth/login.php');

  }

?>
