<?php

  // Memulai Session
  session_start();

  // Menerima Request
  $id_produk = isset($_REQUEST['id_produk']) ? $_REQUEST['id_produk'] : false;
  
  // Mengambil Cart Session
  $cartArr = isset($_SESSION['cart']) ? $_SESSION['cart'] : false;

  // Default Response
  $status = false;
  $message = "Kesalahan tidak diketahui";

  // Error Handling
  if (!$id_produk) {
    // Response
    $status = true;
    $message = "Data request tidak valid, Id Produk Salah";
  } else {
    // Loop Cart Arr untuk mencari produk yg ingin dihapus
    foreach ($cartArr['cart_list'] as $key => $data) {
      // Mencari data yang di request
      if ($data['id_produk'] == $id_produk) {
        
        // Mengambil sub total diskon & harga dari produk yg ingin dihapus
        $sub_total_diskon = $data['diskon'] * $data['jumlah'];
        $sub_total_harga_awal = $data['harga_produk']*$data['jumlah'];
        $sub_total_harga_akhir = $data['sub_total'];

        // Menguragi total diskon & total harga pada data cart session
        $cartArr['total_diskon'] -= $sub_total_diskon;
        $cartArr['total_harga_awal'] -= $sub_total_harga_awal;
        $cartArr['total_harga_akhir'] -= $sub_total_harga_akhir;

        // Menghapus data yg di request
        unset($cartArr['cart_list'][$key]);

        // Response
        $status = true;
        $message = "Request berhasil, Data telah dihapus";
      }
    }
    // Mereset urutan nomor index pada array cart list & mengupdate data cart session
    $_SESSION['cart']['cart_list'] = array_values($cartArr['cart_list']);
    // Mengupdate total diskon
    $_SESSION['cart']['total_diskon'] = $cartArr['total_diskon'];
    // Mengupdate total harga awal
    $_SESSION['cart']['total_harga_awal'] = $cartArr['total_harga_awal'];
    // Mengupdate total harga akhir
    $_SESSION['cart']['total_harga_akhir'] = $cartArr['total_harga_akhir'];

    // Menghapus Session Cart Jika data cart list kosong
    if ( empty($_SESSION['cart']['cart_list']) ) {
      unset($_SESSION['cart']);
    }
  }
  
  // Mengirim Response
  echo json_encode(
    array(
      "status" => $status,
      "message" => $message
    )
  );

?>