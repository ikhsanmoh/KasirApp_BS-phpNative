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
  $response = "";

  // Query - Select 3 Produk Terbaru
  $query = "SELECT 
              nama, nama_kat, stok 
            FROM 
              tb_products 
            INNER JOIN 
              tb_categories 
            ON 
              tb_products.id_kat = tb_categories.id_kat 
            ORDER BY 
              id_produk 
            DESC LIMIT 3";

  // Eksekusi Query
  $sql = mysqli_query($koneksi, $query);

  // Error Handling - Cek Status Query
  if (!$sql) {
    // Response
    $status = true;
    $message = "Kesalahan pada Query (".mysqli_error($koneksi).")";
  } else {
    // Menyiapkan Response
    $no = 1;
    while ( $data = mysqli_fetch_assoc($sql) ) {
      $response .= '<tr>
                      <td scope="row">'.$no++.'</td>
                      <td>'.ucfirst($data['nama']).'</td>
                      <td>'.ucfirst($data['nama_kat']).'</td>
                      <td>'.$data['stok'].'</td>
                    </tr>';
    }
    // Response
    $status = true;
    $message = "Berhasil load data latest product";
  }

  echo json_encode(
    array(
      "status" => $status,
      "message" => $message,
      "response" => $response
    )
  );