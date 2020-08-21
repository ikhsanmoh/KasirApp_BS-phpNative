<?php
  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";
  
  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";


  if ( isset($_GET['id']) ) {
    
    // Mengambil Id dari URL
    $id = $_GET['id'];

    // Query untuk menghapus data
    $query = "DELETE FROM tb_products WHERE id_produk LIKE '$id'";

    // Eksekusi Query
    $sql = mysqli_query($koneksi, $query);

    // Pengkondisian untuk status Query
    if ($sql) {

      // Redirect dengan status sukses
      header('location: '. $base . 'app/pages/products/product.php?status=sukses_delete');
    
    } else {

      // Redirect dengan status gagal
      header('location: '. $base . 'app/pages/products/product.php?status=gagal_delete');

    }

  } else {

    // Redirect untuk perlindungan URL
    header('location: '. $base . 'app/pages/products/product.php');

  }
?>