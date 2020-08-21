<?php

  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";
  
  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  if ( isset($_POST['form_add_category']) ) {
    
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    // var_dump($nama, $email, $password, $konfirm_password);
    // die();

    // Query Select untuk mengecek kesamaan nama kategori
    $query_1 = "SELECT nama_kat FROM tb_categories WHERE nama_kat LIKE '$nama'";

    // Eksekusi Query 1
    $sql_1 = mysqli_query($koneksi, $query_1);

    if ( mysqli_num_rows($sql_1) != 0 ) {
    
      // Redirect dengan status error kesamaan nama kategori
      header('location: '. $base .'app/pages/products/add-category.php?status=err_01');      

    } else {
    
      // Query Insert untuk menyimpan data kategori baru
      $query_2 = "INSERT INTO tb_categories (nama_kat, deskripsi_kat) VALUE ('$nama', '$deskripsi')";
      
      // Eksekusi Query 2
      $sql_2 = mysqli_query($koneksi, $query_2);

      // Kondisi proses penyimpanan data kategori
      if ($sql_2) {
        header('location: '. $base .'app/pages/products/category.php?status=sukses_add');
      } else {
        header('location: '. $base .'app/pages/products/category.php?status=gagal_add');
      }
      
    }

    // Membersihkan data POST
    $_POST = array();

  } else {
    // Redirect sebagai Perlindungan URL
    header('location: '. $base .'app/auth/login.php');
  }
?>