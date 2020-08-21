<?php 

  // Mengambil Base URL
  include "../../../config/url-base.php";

  // Mengecek Status Login Session
  require_once "../../auth/login-session.php";

  // Memanggil Koneksi
  require "../../../config/koneksi.php";

  $kd_item = $_REQUEST['kd'];

  // Query Select data pada 2 tabel yang berelasi
  $query = "SELECT 
              id_produk, nama, nama_kat, stok, harga
            FROM 
              tb_products 
            INNER JOIN 
              tb_categories 
            ON 
              tb_products.id_kat = tb_categories.id_kat
            WHERE
              id_produk LIKE '$kd_item'";
  
  // Eksekusi Query
  $sql = mysqli_query($koneksi, $query);

  if (mysqli_num_rows($sql) == 0) {
    $response = "Data gagal di akses!";
  } else {
    // Fetch data sebagai array
    $arr = mysqli_fetch_array($sql);

    // Konversi data array menjadi json
    $response = json_encode($arr);
  }

  // Mengirim respons data dalam bentuk string
  echo $response;
?>