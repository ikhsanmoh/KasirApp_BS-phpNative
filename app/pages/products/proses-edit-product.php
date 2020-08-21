<?php
  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";
  
  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  if ( isset($_POST['form_edit_product']) ) {
    
    $id = $_POST['id_produk'];
    $nama_lama = $_POST['nama_lama'];
    $nama_baru = $_POST['nama_baru'];
    $kategori = (int) $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // var_dump($id, $nama_lama, $nama_baru, $kategori, $harga, $stok);
    // die();
    
    // Pengkondisian jika ada perubahan Nama Produk
    if ($nama_lama <> $nama_baru) {
      
      // Query Select untuk mengecek kesamaan nama Produk
      $query_1 = "SELECT nama FROM tb_products WHERE nama LIKE '$nama_baru'";
      
      // Eksekusi Query 1
      $sql_1 = mysqli_query($koneksi, $query_1);
      
      if ( mysqli_num_rows($sql_1) != 0 ) {
      
        // Redirect dengan status error kesamaan nama Produk
        header('location: '. $base .'app/pages/products/edit-product.php?status=err_01&id=' . $id);
        die(); // Menghentikan program
  
      }
    }

    // Query untuk update data
    $query_2 = "UPDATE
                  tb_products
                SET
                  nama = '$nama_baru', 
                  id_kat = '$kategori',
                  harga = '$harga',
                  stok = '$stok' 
                WHERE
                  id_produk LIKE '$id'";

    // Eksekusi Query
    $sql_2 = mysqli_query($koneksi, $query_2) OR die("Query fail: " . mysqli_error($koneksi));

    // Pengkondisian Status Query
    if ($sql_2) {

      // Redirect dengan status sukses
      header('location: '. $base . 'app/pages/products/product.php?status=sukses_update');

    } else {
      
      // Redirect dengan status gagal
      header('location: '. $base . 'app/pages/products/product.php?status=gagal_update');
    
    }

  } else {

    // Redirect untuk perlindungan URL
    header('location: '. $base .'app/pages/products/product.php');
    
  } 

?>