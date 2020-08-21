<?php

// TODO : Fitur Laporan PDF butuh pengoptimalan lagi
/**
 *! Masih banyak query dan kode yang berulang
 *! URL masih belum terproteksi
 *! Pengkondisian terlalu banyak
 *! Output dari PDF bergantung pada data(id_invoice, filter_data) session yg mana kurang efektif dan teralu kompleks
 */

// Memanggil Koneksi
require "../../../config/koneksi.php";

// Mengambil Base URL
include "../../../config/url-base.php";

// Mengecek Status Login Session
require_once "../../auth/login-session.php";

// Memanggil Plugin - dompdf
require_once '../../../libs/dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

// Style Laporan
$style = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">';
// data default laporan
$isiLaporan = '<center><h1>Laporan Penjualan</h1></center><br><hr></br>';

// Blok untuk membuat isi laporan berdasarkan id_invoice
if (isset($_SESSION['print_id_invoice'])) {
  $id_inv = $_SESSION['print_id_invoice'];

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
                SUM((tb_products.harga-tb_order_line.diskon)*tb_order_line.quantity) AS grand_total_akhir 
              FROM 
                tb_invoice 
              INNER JOIN 
                tb_order_line ON tb_invoice.id_invoice = tb_order_line.id_invoice 
              INNER JOIN 
                tb_products ON tb_order_line.id_produk = tb_products.id_produk 
              WHERE 
                tb_invoice.id_invoice = '$id_inv'";

  // Ekesusi Query
  $sql = mysqli_query($koneksi, $query);

  // Cek status query
  if (!$sql) {
    echo "Kesalahan pada Query (" . mysqli_error($koneksi) . ")";
  } else {

    // Fetch data Invoice
    $data_inv = mysqli_fetch_assoc($sql);

    // Memasukan invoice_number & tanggal transaksi
    $invoice_num = $data_inv['id_invoice'];
    $tgl_transaksi = $data_inv['created_at'];

    // Memasukan grand_total_akhir
    $grand_total_akhir = $data_inv['grand_total_akhir'];

    // Memasukan data gabungan group_concat ke dalam array
    $id_produk_arr = explode(",", $data_inv['id_produk']);
    $nama_produk_arr = explode(",", $data_inv['nama_produk']);
    $harga_awal_arr = explode(",", $data_inv['harga_awal']);
    $diskon_arr = explode(",", $data_inv['diskon']);
    $harga_akhir_arr = explode(",", $data_inv['harga_akhir']);
    $jumlah_arr = explode(",", $data_inv['jumlah']);
    $sub_total_akhir_arr = explode(",", $data_inv['sub_total_akhir']);

    // Menyiapkan Isi Laporan
    $isiLaporan .= '<p>Invoice : ' . $invoice_num . '</p>
                    <p>Tanggal : ' . $tgl_transaksi . '</p>
                    <table class="table table-sm table-bordered text-center">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Kode</th>
                          <th scope="col">Nama Produk</th>
                          <th scope="col">Harga Awal</th>
                          <th scope="col">Diskon</th>
                          <th scope="col">Harga Akhir</th>
                          <th scope="col">Jumlah</th>
                          <th scope="col">Sub Total</th>
                        </tr>
                      </thead>
                      <tbody>';
    $no = 1;
    foreach ($id_produk_arr as $key => $val) {
      $isiLaporan .=  '<tr>
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

    $isiLaporan .= '<tr>
                      <td colspan="7">Total</td>
                      <td>Rp. ' . number_format($grand_total_akhir, 0, '', '.') . '</td>
                    </tr>
                    </tbody>
                  </table>';
  }
  // Hapus Data print id_invoice session
  unset($_SESSION['print_id_invoice']);
} elseif (isset($_SESSION['filter_reports'])) {
  // Blok untuk membuat isi laporan dari semua data invoice atau berdasarkan filter invoice
  // Copy isi Session filter_reports
  $filter_reports = $_SESSION['filter_reports'];

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

  // Blok Filter data invoice
  if (!empty($filter_reports['tgl_awal']) || !empty($filter_reports['tgl_akhir']) || !empty($filter_reports['inv_num'])) {
    $tgl_awal = !empty($filter_reports['tgl_awal']) ? $filter_reports['tgl_awal'] : "";
    $tgl_akhir = !empty($filter_reports['tgl_akhir']) ? $filter_reports['tgl_akhir'] : "";
    $inv_num = !empty($filter_reports['inv_num']) ? $filter_reports['inv_num'] : "";

    // Set Where untuk filter tanggal
    if ((!empty($tgl_awal) && !empty($tgl_akhir)) && empty($inv_num)) {

      $whereQuery = "WHERE created_at BETWEEN '$tgl_awal' AND '$tgl_akhir' + INTERVAL 1 DAY";
    } elseif ((!empty($tgl_awal) || !empty($tgl_akhir)) && empty($inv_num)) {

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
    echo "Kesalahan pada Query (" . mysqli_error($koneksi) . ")";
  } else {
    // Menyiapkan Isi Laporan
    if (!empty($tgl_awal) && !empty($tgl_akhir)) {
      $isiLaporan .= '<p>Tanggal : ' . $tgl_awal . ' s/d ' . $tgl_akhir . '</p>';
    } elseif (!empty($tgl_awal) || !empty($tgl_akhir)) {
      // Mengambil salah satu input tanggal
      $tgl = !empty($tgl_awal) ? $tgl_awal : $tgl_akhir;
      $isiLaporan .= '<p>Tanggal : ' . $tgl . '</p>';
    } else {
      $isiLaporan .= '<p>Tanggal : - </p>';
    }
    $isiLaporan .= '<table class="table table-sm table-bordered text-center">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Invoice Number</th>
                          <th scope="col">Tanggal</th>
                          <th scope="col">Total Awal</th>
                          <th scope="col">Total Diskon</th>
                          <th scope="col">Total Akhir</th>
                        </tr>
                      </thead>
                      <tbody>';
    $no = 1;
    $grand_total = 0;
    while ($data = mysqli_fetch_array($sql)) {
      $isiLaporan .= '<tr>
                        <th scope="row">' . $no++ . '</th>
                        <td>' . $data['id_invoice'] . '</td>
                        <td>' . $data['created_at'] . '</td>
                        <td>Rp. ' . number_format($data['total_awal'], 0, '', '.') . '</td>
                        <td>Rp. ' . number_format($data['total_diskon'], 0, '', '.') . '</td>
                        <td>Rp. ' . number_format($data['total_akhir'], 0, '', '.') . '</td>
                      </tr>';
      $grand_total += $data['total_akhir'];
    }

    $isiLaporan .= '<tr>
                      <td colspan="5">Total</td>
                      <td>Rp. ' . number_format($grand_total, 0, '', '.') . '</td>
                    </tr>
                    </tbody>
                  </table>';
  }
  // Menghapus Session Filter Reports
  unset($_SESSION['filter_reports']);
}



// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
// load isi laporan
$dompdf->loadHtml($style . $isiLaporan);
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream('laporan_penjualan.pdf', ['Attachment' => 0]);
