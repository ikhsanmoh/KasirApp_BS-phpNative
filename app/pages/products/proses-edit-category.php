<?php
  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";
  
  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  if ( isset($_POST['form_edit_category']) ) {
    
    $id = $_POST['id'];
    $nama_lama = $_POST['nama_lama'];
    $nama_baru = $_POST['nama_baru'];
    $deskripsi = $_POST['deskripsi'];

    // var_dump($nama_lama, $nama_baru, $sql_1, $test);
    // die();
    
    // Pengkondisian jika ada perubahan Nama Kategori
    if ($nama_lama <> $nama_baru) {
      
      // Query Select untuk mengecek kesamaan nama kategori
      $query_1 = "SELECT nama_kat FROM tb_categories WHERE nama_kat LIKE '$nama_baru'";
      
      // Eksekusi Query 1
      $sql_1 = mysqli_query($koneksi, $query_1);
      
      if ( mysqli_num_rows($sql_1) != 0 ) {
      
        // Redirect dengan status error kesamaan nama kategori
        header('location: '. $base .'app/pages/products/edit-category.php?status=err_01&id=' . $id);
        die(); // Menghentikan program
  
      }
    }

    // Query untuk update data
    $query_2 = "UPDATE
                  tb_categories
                SET
                  nama_kat = '$nama_baru', 
                  deskripsi_kat = '$deskripsi' 
                WHERE
                  id_kat LIKE '$id'";

    // Eksekusi Query
    $sql_2 = mysqli_query($koneksi, $query_2);

    // Pengkondisian Status Query
    if ($sql_2) {

      // Redirect dengan status sukses
      header('location: '. $base . 'app/pages/products/category.php?status=sukses_update');

    } else {
      
      // Redirect dengan status gagal
      header('location: '. $base . 'app/pages/products/category.php?status=gagal_update');
    
    }

  } else {

    // Redirect untuk perlindungan URL
    header('location: '. $base .'app/pages/products/category.php');
    
  } 

?>