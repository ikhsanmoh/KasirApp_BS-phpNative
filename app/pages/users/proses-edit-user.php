<?php

  // Memanggil Koneksi
  require "../../../config/koneksi.php";
  
  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  // Mengambil Base URL
  include "../../../config/url-base.php";

  if ( isset($_POST['form_edit_user']) ) {
    
    $id = $_POST['id'];
    $nama_lama = $_POST['nama_lama'];
    $nama_baru = $_POST['nama_baru'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email_lama = $_POST['email_lama'];
    $email_baru = $_POST['email_baru'];
    $lv = $_POST['level'];
    $alamat = $_POST['alamat'];
    $no_tlp = $_POST['no_telepon'];

    // var_dump($id, $nama, $jenis_kelamin, $email, $lv, $alamat, $no_tlp);
    // die();

    // Pengkondisian jika ada perubahan Nama atau Email User
    if ($nama_lama <> $nama_baru || $email_lama <> $email_baru) {
      
      // Query Select untuk mengecek kesamaan nama pendaftar baru
      $query_1 = "SELECT nama, email FROM tb_users WHERE nama LIKE '$nama_baru' OR email LIKE '$email_baru'";

      // Eksekusi Query 1
      $sql_1 = mysqli_query($koneksi, $query_1);

      if ( mysqli_num_rows($sql_1) != 0 ) {
      
        // Redirect dengan status error kesamaan nama atau email
        header('location: '. $base .'app/pages/users/edit-user.php?status=err_01&id=' . $id);      
        die(); // Menghentikan program

      }
    }

    // Query untuk update data
    $query = "UPDATE
                tb_users
              SET
                nama = '$nama_baru', 
                jenis_kelamin = '$jenis_kelamin', 
                email = '$email_baru', 
                level_user = '$lv', 
                alamat = '$alamat', 
                no_telepon = '$no_tlp' 
              WHERE
                id LIKE '$id'";

    // Eksekusi Query
    $sql = mysqli_query($koneksi, $query);

    // Pengkondisian Status Query
    if ($sql) {

      // Redirect dengan status sukses
      header('location: '. $base . 'app/pages/users/user.php?status=sukses_update');

    } else {
      
      // Redirect dengan status gagal
      header('location: '. $base . 'app/pages/users/user.php?status=gagal_update');
    
    }

  } else {

    // Redirect untuk perlindungan URL
    header('location: '. $base .'app/pages/users/user.php');
    
  } 

?>