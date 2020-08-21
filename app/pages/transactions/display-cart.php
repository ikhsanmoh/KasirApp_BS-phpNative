<?php
  
  // Memulai Session
  session_start();
  
  // Default Response
  $status = false;
  $message = "Kesalahan Tidak Diketahui";
  $response = "";
  $dataRes = [];

  // unset($_SESSION['cart']);

  // Cek Cart Session
  if ( isset($_SESSION['cart']) && !empty($_SESSION['cart']['cart_list']) ) {
    
    // Menyiapkan variable
    $cartArr = $_SESSION['cart'];
    $no = 1;
  
    // Menyiapkan Response
    foreach ($cartArr['cart_list'] as $data) {
      $response .= '<tr>
                      <th scope="row">'.$no++.'</th>
                      <td>'.$data['nama_produk'].'</td>
                      <td>'.number_format($data['harga_produk'],0,'','.').'</td>
                      <td>'.number_format($data['diskon'],0,'','.').'</td>
                      <td>'.number_format($data['harga_akhir_produk'],0,'','.').'</td>
                      <td>'.$data['jumlah'].'</td>
                      <td>'.number_format($data['sub_total'],0,'','.').'</td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteItemFromCart('.$data['id_produk'].')"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>';
    }
    
    // Menyiapkan response data lainnya
    $dataRes['invoice_number'] = $cartArr['invoice_number'];
    $dataRes['total_diskon'] = $cartArr['total_diskon'];
    $dataRes['total_awal'] = $cartArr['total_harga_awal'];
    $dataRes['total_akhir'] = $cartArr['total_harga_akhir'];

    // Response
    $status = true;
    $message = "Berhasil Load Cart";

  } else {
    
    // Menyiapkan Response
    $response .= '<tr>
                    <td colspan="8"><center>Keranjang Kosong !</center></td>
                  </tr>';
  
    // Response
    $status = true;
    $message = "Cart Session Kosong";

  }

  echo json_encode(
    array(
      "status" => $status,
      "message" => $message,
      "response" => $response,
      "data" => $dataRes
    )
  );
?>


  