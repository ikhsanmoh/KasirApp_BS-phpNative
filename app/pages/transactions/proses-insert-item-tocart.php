<?php

  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";

  // Memanggil Library
  include "../../../libs/custom-functions.php";

  // Menerima Request
  $id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : false;
  $diskon_produk = isset($_POST['diskon_produk']) ? $_POST['diskon_produk'] : false;
  $jumlah_produk = isset($_POST['jumlah_produk']) ? $_POST['jumlah_produk'] : false;

  // Default Response Status & Pesan
  $status = false;
  $message = "Kesalahan Tidak Diketahui";

  // Error Handling 1 - Cek Request
  if (!$id_produk) {
    // Response
    $status = true;
    $message = "Request Tidak Valid, Id Produk salah!";
  } else {
    if ( isset($_POST['diskon_produk']) && isset($_POST['jumlah_produk']) ) {
      if ($diskon_produk < 0 || $jumlah_produk < 1) {
        // Response
        $status = true;
        $message = "Request Tidak Valid, Input Diskon atau Jumlah Produk salah!";
      } 
    } else {
      // Response
      $status = true;
      $message = "Request Tidak Valid, Input Diskon dan Jumlah Produk tidak boleh kosong!";
    }
  }

  if (!$status) {

    // Query Select data Produk
    $query_1 = "SELECT 
                id_produk, nama, harga
              FROM 
                tb_products
              WHERE
                id_produk LIKE '$id_produk'";
  
    // Query untuk select id_invoice terakhir
    $query_2 = "SELECT id_invoice FROM tb_invoice ORDER BY id_invoice DESC LIMIT 1";
    
    // Eksekusi Query 1
    $sql_1 = mysqli_query($koneksi, $query_1);
    
    // Eksekusi Query 2
    $sql_2 = mysqli_query($koneksi, $query_2);

    // Error Handling 2 - Cek Status Query 1
    if ($sql_1 && mysqli_num_rows($sql_1) != 0) {
      // Fetch Data Produk
      $data = mysqli_fetch_assoc($sql_1);
    } else {
      // Response
      $status = true;
      $message = "Kesalahan pada Query (".mysqli_error($koneksi).")";
    } 

    if ($sql_2 && mysqli_num_rows($sql_2) != 0) {
      // Fetch id invoice terakhir
      $get_data = mysqli_fetch_assoc($sql_2);
      $id_invoice = $get_data['id_invoice'];

      // Ekstrak nomor id_invoice dari tb_invoice
      preg_match_all('!\d+!', $id_invoice, $invoice_number); // Mengambil number pada string id_invoice
      $id_invoice = $invoice_number[0][0] + 1;
    } else {
      $id_invoice = 1;
    }

  }

  if (!$status) {

    /* 
     * Blok untuk logika Cart 
    */

    // Mengolah data produk inputan
    $diskon = ($diskon_produk/100)*$data['harga']; // Hitung diskon
    $harga_akhir_produk = $data['harga'] - $diskon; // Hitung harga item setelah diskon
    $sub_total_harga_awal = $jumlah_produk*$data['harga']; // Hitung Sub total harga awal
    $sub_total_harga_akhir = $jumlah_produk*$harga_akhir_produk; // Hitung Sub Total harga akhir

    // Menyiapkan Data Item yang akan di input ke cart_list
    $dataItem = array(
      "id_produk" => $data['id_produk'],
      "nama_produk" => $data['nama'],
      "harga_produk" => $data['harga'],
      "diskon" => $diskon,
      "harga_akhir_produk" => $harga_akhir_produk,
      "jumlah" => $jumlah_produk,
      "sub_total" => $sub_total_harga_akhir
    );
    
    // Menyiapkan var yg dipakai untuk mengolah data cart
    $total_diskon = 0;
    $total_harga_awal = 0;
    $total_harga_akhir = 0;
    $cart_list = [];

    // Cek jika data cart session sudah ada
    if ( isset($_SESSION['cart']) && !empty($_SESSION['cart']['cart_list']) ) {
      // Ambil Data Pada Cart
      $total_diskon = !empty($_SESSION['cart']['total_diskon']) ? $_SESSION['cart']['total_diskon'] : 0;
      $total_harga_awal = !empty($_SESSION['cart']['total_harga_awal']) ? $_SESSION['cart']['total_harga_awal'] : 0;
      $total_harga_akhir = !empty($_SESSION['cart']['total_harga_akhir']) ? $_SESSION['cart']['total_harga_akhir'] : 0;
      $cart_list = !empty($_SESSION['cart']['cart_list']) ? $_SESSION['cart']['cart_list'] : [];
    }
    
    // Menyiapkan Data Cart lainnya
    $inv = invNumGen($id_invoice, 5, "F-");
    $sub_total_diskon = $dataItem['diskon'] * $dataItem['jumlah'];
    $total_diskon = $total_diskon + $sub_total_diskon;
    $total_harga_awal = $total_harga_awal + $sub_total_harga_awal;
    $total_harga_akhir = $total_harga_akhir + $sub_total_harga_akhir;
    $cart_list[] = $dataItem;

    // Mengecek kesamaan antara data inputan dan data dalam cart list
    if ( isset($_SESSION['cart'])  && !empty($_SESSION['cart']['cart_list']) ) {
      // Loop untuk mengecek jika produk pada request sudah ada dalam session cart
      foreach ($_SESSION['cart']['cart_list'] as $index => $value) {
        // Cek kesamaan id produk antara request dan cart
        if ($value['id_produk'] == $id_produk) {
          // Update Jumlah Item & Sub Total Item
          $_SESSION['cart']['cart_list'][$index]['jumlah'] += $jumlah_produk;
          $_SESSION['cart']['cart_list'][$index]['sub_total'] += $sub_total_harga_akhir;
          $_SESSION['cart']['total_diskon'] = $total_diskon;
          $_SESSION['cart']['total_harga_awal'] = $total_harga_awal;
          $_SESSION['cart']['total_harga_akhir'] = $total_harga_akhir;
          
          // Response
          $status = true;
          $message = "Request Berhasil, Data Item pada cart ditambahkan ";
        }
      }
    } 
  }
  
  if (!$status) {

    // Cek jika session cart belum dideklarasi
    if ( !isset($_SESSION['cart']) ) {
      // Deklarasi var array untuk cart pada session
      $_SESSION['cart'] = [];
    } 

    // Menyiapkan Struktur Data Cart sebagai blueprint Cart pada Session
    $cartArr = array (
      "invoice_number" => null,
      "cart_list" => null,
      "total_diskon" => null,
      "total_harga_awal" => null,
      "total_harga_akhir" => null
    );

    // Menginput Data pada blueprint cart
    $cartArr['invoice_number'] = $inv;
    $cartArr['cart_list'] = $cart_list;
    $cartArr['total_diskon'] = $total_diskon;
    $cartArr['total_harga_awal'] = $total_harga_awal;
    $cartArr['total_harga_akhir'] = $total_harga_akhir;

    // Menyimpan data dari blueprint Cart ke Cart Session
    $_SESSION['cart'] = $cartArr;

    // Response
    $status = true;
    $message = "Request Berhasil, Cart telah dibuat";
  }

  // Mengirim Response
  echo json_encode(
    array(
      "status" => $status,
      "message" => $message
    )
  );

?>