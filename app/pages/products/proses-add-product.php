<?php

  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";
  
  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  if ( isset($_POST['form_add_product']) ) {
    
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];


    // var_dump($nama, $email, $password, $konfirm_password);
    // die();

    // Query Select untuk mengecek kesamaan nama Produk
    $query_1 = "SELECT nama FROM tb_products WHERE nama LIKE '$nama'";

    // Eksekusi Query 1
    $sql_1 = mysqli_query($koneksi, $query_1);

    if ( mysqli_num_rows($sql_1) != 0 ) {
    
      // Redirect dengan status error kesamaan nama Produk
      header('location: '. $base .'app/pages/products/add-product.php?status=err_01');      

    } else {
    
      // Query Insert untuk menyimpan data Produk baru
      $query_2 = "INSERT INTO tb_products (nama, id_kat, harga, stok) VALUE ('$nama', '$kategori', '$harga', '$stok')";
      
      // Eksekusi Query 2
      $sql_2 = mysqli_query($koneksi, $query_2);

      // Kondisi proses penyimpanan data Produk
      if ($sql_2) {
        header('location: '. $base .'app/pages/products/product.php?status=sukses_add');
      } else {
        header('location: '. $base .'app/pages/products/product.php?status=gagal_add');
      }
      
    }

    // Membersihkan data POST
    $_POST = array();

  } else {
    // Redirect sebagai Perlindungan URL
    header('location: '. $base .'app/auth/login.php');
  }
?>