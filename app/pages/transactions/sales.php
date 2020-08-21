<?php

// Mengambil Base URL
include "../../../config/url-base.php";

// Mengecek Status Login Session
require_once "../../auth/login-session.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kasir App - Sales</title>

  <!-- Bootstrap Core CSS -->
  <link rel="stylesheet" href="<? echo $base ?>./styles/bootstrap.min.css">

  <!--Font Awsome Core CSS -->
  <link rel="stylesheet" href="<? echo $base ?>./styles/fontawsome/css/all.min.css">

  <!-- Plugin Datatables Core CSS -->
  <link rel="stylesheet" href="<? echo $base ?>./styles/datatables.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<? echo $base ?>./styles/custom.css">

</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Kasir App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<? echo $base ?>./index.php">Dashboard <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<? echo $base ?>./app/pages/users/user.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<? echo $base ?>./app/pages/products/product.php">Products</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<? echo $base ?>./app/pages/transactions/sales.php">Sales</a>
        </li>
      </ul>
      <ul class="navbar-nav mr-2">

        <!-- Includes Navbar Kanan -->
        <? include "../../includes/navbar-right.php" ?>

      </ul>
    </div>
  </nav>

  <div class="custom-header bg-secondary">
    <div class="container">
      <div class="row">
        <h1 class="h2"><i class="fas fa-money-bill-wave"></i> Sales</h1>
      </div>
    </div>
  </div>

  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="list-group mb-3">
          <a href="<? echo $base ?>./index.php" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="<? echo $base ?>./app/pages/users/user.php" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Users</a>
          <a href="<? echo $base ?>./app/pages/products/category.php" class="list-group-item list-group-item-action"><i class="fas fa-tag"></i> Product Categories</a>
          <a href="<? echo $base ?>./app/pages/products/product.php" class="list-group-item list-group-item-action"><i class="fab fa-product-hunt"></i> Products</a>
          <a href="<? echo $base ?>./app/pages/transactions/sales.php" class="list-group-item list-group-item-action active"><i class="fas fa-money-bill-wave"></i> Sales</a>
          <a href="<? echo $base ?>./app/pages/reports/report.php" class="list-group-item list-group-item-action"><i class="fas fa-file-alt"></i> Report</a>
        </div>
      </div>
      <div class="col-md-9">

        <div class="card mb-3">
          <div class="card-header">Sales</div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-lg-8">

                <form method="post" id="formSelectedItem" onsubmit="return false">

                  <div class="card">
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="inputAddress">Kode Barang</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="kd_item" aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#productModal" type="button">Cari</button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="nama_item">Nama Barang</label>
                          <input type="text" class="form-control" id="nama_item" value="" readonly>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-8">
                          <label for="harga_item">Harga Satuan</label>
                          <input type="text" class="form-control" id="harga_item" value="" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="diskon_item">Diskon</label>
                          <select id="diskon_item" class="form-control">
                            <option value="0" selected>0%</option>
                            <option value="10">10%</option>
                            <option value="30">30%</option>
                            <option value="50">50%</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="jumlah_item">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah_item" placeholder="Masukan Jumlah Barang">
                      </div>
                      <button type="submit" class="btn btn-primary" onclick="insertItemToCart()">Tambah</button>
                    </div>
                  </div>

                </form>
              </div>

              <div class="col-lg-4">

                <div class="card">
                  <div class="card-body">
                    <h1 class="h5">Invoice <small class="font-weight-bold" id="invoice_number"></small></h1>
                    <h1 class="h4 font-weight-bold" id="inv_total_harga">Rp. 15.000.000</h1>
                  </div>
                </div>

              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">

                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive-lg">
                      <table class="table table-sm table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga Awal</th>
                            <th scope="col">Diskon</th>
                            <th scope="col">Harga Akhir</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Sub Total</th>
                            <th scope="col" class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="cartTable">
                          <!-- Data Cart -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="row mb-3">

              <div class="col-md-8">

                <div class="card">
                  <div class="card-body">
                    <form id="formPayment" method="post" onsubmit="return false">

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="total_awal">Total</label>
                          <input type="number" class="form-control" id="total_awal" value="" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="total_diskon">Total Diskon</label>
                          <input type="number" class="form-control" id="total_diskon" value="" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="total_akhir">Total Akhir</label>
                        <input type="number" class="form-control" id="total_akhir" value="" readonly>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="tunai">Bayar</label>
                          <input type="number" class="form-control" id="tunai" name="tunai" onkeyup="uangKembalian()">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="kembalian">Kembalian</label>
                          <input type="number" class="form-control" id="kembalian" value="" readonly>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary" id="prosesTransaksi" onclick='prosesOrder()'>Proses Transaksi</button>

                    </form>
                  </div>
                </div>

              </div>
              <div class="col-md-4">

                <div class="card">
                  <div class="card-body text-center">
                    <div style="font-size: 0,5rem; color:#38c95f">
                      <i class="fas fa-check-circle fa-6x" aria-hidden="true"></i>
                    </div>
                    <h1 class="h3">Input Success</h1>
                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Modal - Cari Product -->
  <div class="modal fade" id="productModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="productModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productModal">Cari Produk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-sm table-striped" id="productModalTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kode</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Kategori</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Memanggil Koneksi
              require_once "../../../config/koneksi.php";

              // Query Select data pada 2 tabel yang berelasi
              $query = "SELECT 
                            id_produk, nama, nama_kat, stok, harga
                          FROM 
                            tb_products 
                          INNER JOIN 
                            tb_categories 
                          ON 
                          tb_products.id_kat = tb_categories.id_kat;";

              $sql = mysqli_query($koneksi, $query);
              $no = 1;
              ?>
              <?php while ($data = mysqli_fetch_assoc($sql)) : ?>

                <tr>
                  <th scope="row"><?php echo $no++; ?></th>
                  <td>KD<?php echo $data['id_produk']; ?></td>
                  <td><?php echo ucfirst($data['nama']); ?></td>
                  <td><?php echo ucfirst($data['nama_kat']); ?></td>
                  <td>Rp. <?php echo number_format($data['harga'], 0, '', '.'); ?></td>
                  <td><?php echo $data['stok']; ?></td>
                  <td>
                    <a href="edit-product.php?id=<?php echo $data['id_produk']; ?>" class="btn btn-sm btn-info" role="button" data-dismiss="modal" onclick="selectedItem(<? echo $data['id_produk']; ?>)">
                      <i class="fas fa-check"></i> Select
                    </a>
                    <!-- <a href="edit-product.php?id=<?php //echo $data['id_produk']; 
                                                      ?>" class="btn btn-info btn-sm" role="button">Edit</a>
                    <a href="proses-delete-product.php?id=<?php //echo $data['id_produk']; 
                                                          ?>" class="btn btn-danger btn-sm" role="button" onclick='return confirm("Yakin Hapus?")'>Delete</a> -->
                  </td>
                </tr>

              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



  <div class="footer-placeholder" style="height: 50px;">
    <footer class="footer mt-auto py-3 bg-dark fixed-bottom text-center">
      <div class="container">
        <span class="text-muted">&copy; Ikhsan Mohamad 2020</span>
      </div>
    </footer>
  </div>

  <!-- Jquery Core JS -->
  <script src="<? echo $base ?>./scripts/jquery-3.5.1.min.js"></script>

  <!-- Bootstrap Core JS -->
  <script src="<? echo $base ?>./scripts/bootstrap.min.js"></script>

  <!-- Plugin Datatables Core JS -->
  <script src="<? echo $base ?>./scripts/datatables.min.js"></script>

  <!-- Main JS -->
  <script>
    $(document).ready(function() {
      $('#productModalTable').DataTable();
    });

    window.addEventListener('load', showCart());

    // Fungsi untuk menampilkan isi Cart - AJAX Request
    function showCart() {
      // Deklasri Variabel
      var http = new XMLHttpRequest();
      var res;

      http.onreadystatechange = function() {
        // Cek Status response
        if (this.readyState == 4 && this.status == 200) {

          // Konversi string response ke format json
          res = JSON.parse(this.responseText);

          if (res.status) {
            // Deploy Response
            document.getElementById("cartTable").innerHTML = res.response;
            document.getElementById("invoice_number").innerHTML = res.data.invoice_number ? res.data.invoice_number : "";
            document.getElementById("inv_total_harga").innerHTML = res.data.total_akhir ? res.data.total_akhir : "";
            document.getElementById("total_awal").value = res.data.total_awal ? res.data.total_awal : "";
            document.getElementById("total_diskon").value = res.data.total_diskon ? res.data.total_diskon : "";
            document.getElementById("total_akhir").value = res.data.total_akhir ? res.data.total_akhir : "";
          } else {
            // Error Handling
            alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
          }
        }
      };
      // Mengirim Request
      http.open("GET", "display-cart.php", true);
      http.send();
    }

    // Fungsi untuk Select Item - AJAX Request
    function selectedItem(kd_item) {
      // Deklarasi Variabel
      var http = new XMLHttpRequest();
      var res;

      // Menjalankan fungsi ketika response siap
      http.onreadystatechange = function() {
        // Cek Status response
        if (this.readyState == 4 && this.status == 200) {

          // Konversi string response ke format json
          res = JSON.parse(this.responseText);

          // Memasukan data ke value input Select Item
          document.getElementById("kd_item").value = res.id_produk;
          document.getElementById("nama_item").value = res.nama;
          document.getElementById("harga_item").value = res.harga;
        }
      };
      // Mengirim request
      http.open("GET", "proses-select-item.php?kd=" + kd_item, true);
      http.send();
    }

    // Fungsi untuk Insert Item ke Cart - AJAX
    function insertItemToCart() {
      // Deklarasi Variabel
      var http = new XMLHttpRequest();
      var req, res;

      // Objek untuk koleksi isi Form Select Item
      const formValues = {
        id_produk: document.querySelector("#formSelectedItem #kd_item"),
        diskon_produk: document.querySelector("#formSelectedItem #diskon_item"),
        jumlah_produk: document.querySelector("#formSelectedItem #jumlah_item")
      };

      // Menyiapkan Request
      req = `id_produk=${formValues.id_produk.value}&diskon_produk=${formValues.diskon_produk.value}&jumlah_produk=${formValues.jumlah_produk.value}`;

      // Menjalankan fungsi ketika response siap
      http.onreadystatechange = function() {
        // Cek Status response
        if (this.readyState == 4 && this.status == 200) {

          // Konversi string response ke format json
          res = JSON.parse(this.responseText);

          if (res.status) {
            // Menjalankan Fungsi Show Cart
            showCart();
          } else {
            // Error Handling
            alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
          }
        }
      };
      // Mengirim Request
      http.open("POST", "proses-insert-item-tocart.php", true);
      http.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // digunakan pada metode POST untuk set req berformat key-value pair string
      http.send(req);
    }

    // Fungsi untuk menghapus isi cart - AJAX
    function deleteItemFromCart(id_produk) {

      if (confirm('Hapus Item Cart?')) {
        // Deklarasi Variabel
        var http = new XMLHttpRequest();
        var req, res;

        // Menyiapkan Request
        req = `id_produk=${id_produk}`;

        // Menjalankan fungsi ketika response siap
        http.onreadystatechange = function() {
          // Cek Status response
          if (this.readyState == 4 && this.status == 200) {

            // Konversi string response ke format json
            res = JSON.parse(this.responseText);

            if (res.status) {
              // Menjalankan Fungsi Show Cart
              showCart();
            } else {
              // Error Handling
              alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
            }
          }
        };
        // Mengirim request
        http.open("GET", "proses-delete-item-fromcart.php?" + req, true);
        http.send();
      }
    }

    // Fungsi untuk proses order - AJAX
    function prosesOrder() {

      if (confirm('Input Order?')) {
        // Deklarasi Variabel
        var http = new XMLHttpRequest();
        var req, res;

        // Mengambil Data Form Payment
        const formPaymentVal = {
          total_bayar: document.querySelector('#formPayment #tunai'),
          submit: document.querySelector('#formPayment #prosesTransaksi')
        };

        // Menyiapkan Request
        req = `total_bayar=${formPaymentVal.total_bayar.value}`;

        // Menjalankan fungsi ketika response siap
        http.onreadystatechange = function() {
          // Cek Status response
          if (this.readyState == 4 && this.status == 200) {

            // Konversi string response ke format json
            res = JSON.parse(this.responseText);

            if (res.status) {
              // Menampilkan Alert Sukses
              alert(res.message);
              showCart();
            } else {
              // Error Handling
              alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
            }
          }
        };
        // Mengirim Request
        http.open("POST", "proses-input-order.php", true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send(req);
      }
    }

    // Fungsi untuk perhitungan pembayaran
    function uangKembalian() {
      var tunai = document.getElementById('tunai').value;
      var total = document.getElementById('total_akhir').value;
      var kembalian = parseInt(tunai) - total;

      if (!isNaN(kembalian)) {
        document.getElementById('kembalian').value = kembalian;
      }
    }
  </script>

</body>

</html>