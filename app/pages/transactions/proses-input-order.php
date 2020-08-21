<?php 
  
  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";

  // Menerima Request Data
  $total_bayar = isset($_POST['total_bayar']) ? $_POST['total_bayar'] : false;

  // Default Response
  $status = false;
  $message = "Kesalahan Tidak Diketahui";

  // Error Handling 1 - Cek Request
  if (!$total_bayar) {
    // Response
    $status = true;
    $message = "Request Tidak Valid";
  }

  // Blok untuk menginput data tb_invoice
  if (isset($_SESSION['cart']) && !$status) {
    // Mengambil data cart session
    $cartArr = $_SESSION['cart'];
  
    // Menyiapkan data cart untuk di input ke database
    $id_invoice = $cartArr['invoice_number'];
    $total_harga = $cartArr['total_harga_akhir'];
  
    // Menyiapkan Invoice Timestamp
    ini_set('date.timezone', 'Asia/Jakarta');
    $timestamp = date('Y-m-d H:i:s');
    
    // Query - Input Invoice data ke tb_invoice
    $query = "INSERT INTO tb_invoice (id_invoice, total, bayar, created_at) VALUE ('$id_invoice', '$total_harga', '$total_bayar', '$timestamp')";
    
    // Ekseskusu Query
    $sql = mysqli_query($koneksi, $query);

    // Error Handling 3 - Cek status Query
    if (!$sql) {
      // Response
      $status = true;
      $message = "Kesalahan pada Query (".mysqli_error($koneksi).")";
    }
  }

  // Blok untuk menginput data tb_order_line
  if (!$status) {
    // Loop untuk Input data Cart list
    foreach ($cartArr['cart_list'] as $data) {
      // Menyiapkan data Cart list untuk di input ke database
      $id_produk = $data['id_produk'];
      $diskon = $data['diskon'];
      $qty = $data['jumlah'];

      // Query - Insert data Cart ke tb_order_line
      $query = "INSERT INTO tb_order_line (id_invoice, id_produk, diskon, quantity) VALUE ('$id_invoice', '$id_produk', '$diskon', '$qty')";
      
      // Eksekusi Query
      $sql = mysqli_query($koneksi, $query);
      
      // Error Handling 4 - Cek status Query
      if (!$sql) {
        // Response
        $status = true;
        $message = "Kesalahan pada Query (".mysqli_error($koneksi).")";
        break; // Keluar dari loop
      } else {
        // Response
        $status = true;
        $message = "Request Berhasil, Order Berhasil di store ke database";
        // Mengosongkan Session Cart
        unset($_SESSION['cart']);
      }
    }
  }

  // Mengirim Response
  echo json_encode(
    array(
      "status" => $status,
      "message" => $message
    )
  );
