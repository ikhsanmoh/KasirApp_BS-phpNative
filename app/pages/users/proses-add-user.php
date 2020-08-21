<?php

  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";
  
  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  if ( isset($_POST['form_add_user']) ) {
    
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email = $_POST['email'];
    $lv = $_POST['level'];
    $alamat = $_POST['alamat'];
    $no_tlp = $_POST['no_telepon'];

    // Meng-Encript Password
    $password = md5($_POST['password']);;
    $konfirm_password = md5($_POST['konfirm_password']);

    // var_dump($nama, $email, $password, $konfirm_password);
    // die();

    // Query Select untuk mengecek kesamaan nama pendaftar baru
    $query_1 = "SELECT nama, email FROM tb_users WHERE nama LIKE '$nama' OR email LIKE '$email'";

    // Eksekusi Query 1
    $sql_1 = mysqli_query($koneksi, $query_1);

    if ( mysqli_num_rows($sql_1) != 0 ) {
    
      // Redirect dengan status error kesamaan nama atau email
      header('location: '. $base .'app/pages/users/add-user.php?status=err_01');      

    } else {
    
      if ($password <> $konfirm_password) {
        
        // Redirect dengan status error password
        header('location: '. $base .'app/pages/users/add-user.php?status=err_02');

      } else {
    
        // Query Insert untuk menyimpan data pendaftar baru
        $query_2 = "INSERT INTO 
                      tb_users (nama, jenis_kelamin, email, pass, alamat, no_telepon, level_user) 
                    VALUE 
                      ('$nama', '$jenis_kelamin', '$email', '$password', '$alamat', '$no_tlp', '$lv')";
        
        // Eksekusi Query 2
        $sql_2 = mysqli_query($koneksi, $query_2);

        // Kondisi proses penyimpanan data pendaftar
        if ($sql_2) {
          header('location: '. $base .'app/pages/users/user.php?status=sukses_add');
        } else {
          header('location: '. $base .'app/pages/users/user.php?status=gagal_add');
        }
      
      }
      
    }

    // Membersihkan data POST
    $_POST = array();

  } else {
    // Redirect sebagai Perlindungan URL
    header('location: '. $base .'app/auth/login.php');
  }
?>