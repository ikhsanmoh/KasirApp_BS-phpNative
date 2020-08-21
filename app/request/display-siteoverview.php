<?php

    // Mengambil Base URL
    include "../../config/url-base.php";

    // Mengecek Status Login Session
    require_once "../auth/login-session.php";
  
    // Memanggil Koneksi
    require "../../config/koneksi.php";

    // Default Response
    $status = false;
    $message = "Kesalahan Tidak Diketahui";
    $data = [];

    // Query - Select jumlah Users
    $query = "SELECT id FROM tb_users";

    // Eksekusi Query
    $sql = mysqli_query($koneksi, $query);

    // Error Handling 1 - Cek status Query
    if ($sql) {
      $data['jumlah_users'] = mysqli_num_rows($sql);
    } else {
      // Response
      $status = true;
      $message = "Kesalahan pada Query (".mysqli_error($koneksi).")";
    }

    if (!$status) {
      // Query - Select jumlah product
      $query = "SELECT id_produk FROM tb_products";
  
      // Eksekusi Query
      $sql = mysqli_query($koneksi, $query);
  
      // Error Handling 2 - Cek status Query
      if ($sql) {
        $data['jumlah_produk'] = mysqli_num_rows($sql);
      } else {
        // Response
        $status = true;
        $message = "Kesalahan pada Query (".mysqli_error($koneksi).")";
      }  
    }


    if (!$status) {
      // Query - Select jumlah categories
      $query = "SELECT id_kat FROM tb_categories";

      // Eksekusi Query
      $sql = mysqli_query($koneksi, $query);

      // Error Handling 3 - Cek Status Query
      if ($sql) {
        $data['jumlah_kategori'] = mysqli_num_rows($sql);
      } else {
        // Response
        $status = true;
        $message = "Kesalahan pada Query (".mysqli_error($koneksi).")";
      }

      // Response
      $status = true;
      $message = "Berhasil Meload Data Site Overview";
    }

    echo json_encode(
      array(
        "status" => $status,
        "message" => $message,
        "data" => $data
      )
    );