<?php

// Memanggil Koneksi
require "../../../config/koneksi.php";

// Mengambil Base URL
include "../../../config/url-base.php";

// Mengecek Status Login Session
require_once "../../auth/login-session.php";

// Menyiapkan Request
$id_invoice = isset($_REQUEST['id']) ? $_REQUEST['id'] : false;

// Default Response
$status = false;
$message = "Kesalahan Tidak Diketahui";
$response = "";

if (!$id_invoice) {
  // Response
  $status = true;
  $message = "Request tidak valid!";
}

if (!$status) {

  // Query - Select Inner Join (tb_invoice, tb_order_line, tb_products) dan menggabung multiple data dalam 1 baris
  $query = "SELECT 
                tb_invoice.id_invoice, 
                tb_invoice.created_at, 
                GROUP_CONCAT(tb_products.id_produk) AS id_produk, 
                GROUP_CONCAT(tb_products.nama) AS nama_produk, 
                GROUP_CONCAT(tb_products.harga) AS harga_awal, 
                GROUP_CONCAT(tb_order_line.diskon) AS diskon, 
                GROUP_CONCAT(tb_products.harga-tb_order_line.diskon) AS harga_akhir, 
                GROUP_CONCAT(tb_order_line.quantity) AS jumlah,
                GROUP_CONCAT((tb_products.harga-tb_order_line.diskon)*tb_order_line.quantity) AS sub_total_akhir,
                -- SUM(tb_products.harga*tb_order_line.quantity) AS grand_total_awal, //? Penggunaan Data ini masih dalam pertimbangan
                -- SUM(tb_order_line.diskon*tb_order_line.quantity) AS grand_diskon , //? Penggunaan Data ini masih dalam pertimbangan
                SUM((tb_products.harga-tb_order_line.diskon)*tb_order_line.quantity) AS grand_total_akhir 
              FROM 
                tb_invoice 
              INNER JOIN 
                tb_order_line ON tb_invoice.id_invoice = tb_order_line.id_invoice 
              INNER JOIN 
                tb_products ON tb_order_line.id_produk = tb_products.id_produk 
              WHERE 
                tb_invoice.id_invoice = '$id_invoice'";

  // Ekesusi Query
  $sql = mysqli_query($koneksi, $query);

  // Cek status query
  if (!$sql) {
    // Response
    $status = true;
    $message = "Kesalahan pada Query (" . mysqli_error($koneksi) . ")";
  } else {
    // Fetch data Invoice
    $data_inv = mysqli_fetch_assoc($sql);
  }
}

if (!$status) {

  //TODO: Fetching data butuh di optimalkan lagi
  //! Fetching data dgn foreach memanfaatkan index id_produk untuk meretrive semua data hasil GROUP_CONCAT yang di explode dari database

  // Memasukan invoice_number & tanggal transaksi
  $invoice_num = $data_inv['id_invoice'];
  $tgl_transaksi = $data_inv['created_at'];

  // Memasukan grand_total_awal, grand_diskon, grand_total_akhir
  // $grand_total_awal = $data_inv['grand_total_awal']; //? Penggunaan Data ini masih dalam pertimbangan
  // $grand_diskon = $data_inv['grand_diskon']; //? Penggunaan Data ini masih dalam pertimbangan
  $grand_total_akhir = $data_inv['grand_total_akhir'];

  // Memasukan data gabungan group_concat ke dalam array
  $id_produk_arr = explode(",", $data_inv['id_produk']);
  $nama_produk_arr = explode(",", $data_inv['nama_produk']);
  $harga_awal_arr = explode(",", $data_inv['harga_awal']);
  $diskon_arr = explode(",", $data_inv['diskon']);
  $harga_akhir_arr = explode(",", $data_inv['harga_akhir']);
  $jumlah_arr = explode(",", $data_inv['jumlah']);
  $sub_total_akhir_arr = explode(",", $data_inv['sub_total_akhir']);

  // Menyiapkan Response HTML
  $no = 1;
  foreach ($id_produk_arr as $key => $val) {
    $response .=  '<tr>
                      <th scope="row">' . $no++ . '</th>
                      <td>KD' . $id_produk_arr[$key] . '</td>
                      <td>' . $nama_produk_arr[$key] . '</td>
                      <td>Rp. ' . number_format($harga_awal_arr[$key], 0, '', '.') . '</td>
                      <td>Rp. ' . number_format($diskon_arr[$key], 0, '', '.') . '</td>
                      <td>Rp. ' . number_format($harga_akhir_arr[$key], 0, '', '.') . '</td>
                      <td>' . $jumlah_arr[$key] . '</td>
                      <td>Rp. ' . number_format($sub_total_akhir_arr[$key], 0, '', '.') . '</td>
                    </tr>';
  }

  $response .= '<tr>
                    <td colspan="7" class="text-center">Total</td>
                    <td>RP. ' . number_format($grand_total_akhir, 0, '', '.') . '</td>
                  </tr>';

  // Membuat Session untuk keperluan Print Report
  $_SESSION['print_id_invoice'] = $id_invoice;

  // Response
  $status = true;
  $message = "Berhasil meload data";
}

echo json_encode(
  array(
    "status" => $status,
    "message" => $message,
    "response" => $response,
    "data" => [
      "invoice_number" => $invoice_num,
      "tanggal_transaksi" => $tgl_transaksi
    ]
  )
);
