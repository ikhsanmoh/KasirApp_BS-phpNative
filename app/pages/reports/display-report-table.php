<?php

// Memanggil Koneksi
require "../../../config/koneksi.php";

// Mengambil Base URL
include "../../../config/url-base.php";

// Mengecek Status Login Session
require_once "../../auth/login-session.php";


// Default Response
$status = false;
$message = "Kesalahan Tidak Diketahui";
$response = "";

// Main Query
$selectQuery = "SELECT 
                  tb_invoice.id_invoice, 
                SUM(tb_products.harga*tb_order_line.quantity) AS total_awal ,
                SUM(tb_order_line.diskon*tb_order_line.quantity) AS total_diskon, 
                  tb_invoice.total AS total_akhir, 
                  tb_invoice.created_at 
                FROM 
                  tb_invoice 
                INNER JOIN 
                  tb_order_line ON tb_invoice.id_invoice = tb_order_line.id_invoice 
                INNER JOIN 
                  tb_products ON tb_order_line.id_produk = tb_products.id_produk ";
$groupByQuery = " GROUP BY tb_invoice.id_invoice";
$whereQuery = "";

//TODO: Blok filter report butuh di optimalan lagi
//! Pengkondisian terlalu banyak pada blok filter report
// Blok Filter data invoice
if (!empty($_REQUEST['tgl_awal']) || !empty($_REQUEST['tgl_akhir']) || !empty($_REQUEST['inv_num'])) {
  $tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : "";
  $tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : "";
  $inv_num = !empty($_REQUEST['inv_num']) ? $_REQUEST['inv_num'] : "";

  // Set Where untuk filter tanggal
  if ((!empty($tgl_awal) && !empty($tgl_akhir)) && empty($inv_num)) {
    // Ubah Format taggal awal & akhir sesuai format timestamp pada database
    //// $tgl_awal = date_create($tgl_awal);
    //// $tgl_akhir = date_create($tgl_akhir);
    //// $tgl_awal = date_format($tgl_awal, "Y-m-d");
    //// $tgl_akhir = date_format($tgl_akhir, "Y-m-d");

    $whereQuery = "WHERE created_at BETWEEN '$tgl_awal' AND '$tgl_akhir' + INTERVAL 1 DAY";
  } elseif ((!empty($tgl_awal) || !empty($tgl_akhir)) && empty($inv_num)) {
    // Ubah Format taggal awal sesuai format timestamp pada database
    //// $tgl_awal = date_create($tgl_awal);
    //// $tgl_awal = date_format($tgl_awal, "Y-m-d");

    // Mengambil salah satu input tanggal
    $tgl = !empty($tgl_awal) ? $tgl_awal : $tgl_akhir;

    $whereQuery = "WHERE DATE(created_at) LIKE '$tgl'";
  } elseif ((empty($tgl_awal) && empty($tgl_akhir)) && !empty($inv_num)) {

    $whereQuery = "WHERE tb_invoice.id_invoice LIKE 'F-%$inv_num%'";
  } elseif ((!empty($tgl_awal) && !empty($tgl_akhir)) && !empty($inv_num)) {

    $whereQuery = "WHERE created_at BETWEEN '$tgl_awal' AND '$tgl_akhir' + INTERVAL 1 DAY AND tb_invoice.id_invoice LIKE 'F-%$inv_num%'";
  } elseif ((!empty($tgl_awal) || !empty($tgl_akhir)) && !empty($inv_num)) {
    // Mengambil salah satu input tanggal
    $tgl = !empty($tgl_awal) ? $tgl_awal : $tgl_akhir;

    $whereQuery = "WHERE DATE(created_at) LIKE '$tgl' AND tb_invoice.id_invoice LIKE 'F-%$inv_num%'";
  }
}

// Query Final - Select Inner Join (tb_invoice, tb_order_line, tb_products)
$queryFinal = $selectQuery . $whereQuery . $groupByQuery;

// Eksekusi Query
$sql = mysqli_query($koneksi, $queryFinal);

// Cek Status Query
if (!$sql) {
  // Response
  $status = true;
  $message = "Kesalahan pada Query (" . mysqli_error($koneksi) . ")";
}

if (!$status) {
  $no = 1;
  $kutip = "'"; //Kutip untuk passing string sbgai js func argumen
  while ($data = mysqli_fetch_array($sql)) {
    $response .= '<tr>
                      <th scope="row">' . $no++ . '</th>
                      <td>' . $data['id_invoice'] . '</td>
                      <td>' . $data['created_at'] . '</td>
                      <td>Rp. ' . number_format($data['total_awal'], 0, '', '.') . '</td>
                      <td>Rp. ' . number_format($data['total_diskon'], 0, '', '.') . '</td>
                      <td>Rp. ' . number_format($data['total_akhir'], 0, '', '.') . '</td>
                      <td>
                        <button class="btn btn-sm btn-info" id="showReportDetail" onclick="showReportDetail(' . $kutip . $data['id_invoice'] . $kutip . ');" type="button">Detail</button>
                      </td>
                    </tr>';
  }

  // Membuat Session untuk keperluan Print Report
  $_SESSION['filter_reports'] = [
    "tgl_awal" => !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : null,
    "tgl_akhir" => !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : null,
    "inv_num" => !empty($_REQUEST['inv_num']) ? $_REQUEST['inv_num'] : null
  ];

  // Response
  $status = true;
  $message = "Berhasil load data invoice";
}

echo json_encode(
  array(
    "status" => $status,
    "message" => $message,
    "response" => $response
  )
);
