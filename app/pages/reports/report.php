<?php

// Mengambil Base URL
include "../../../config/url-base.php";

// Mengecek Status Login Session
require_once "../../auth/login-session.php";

// Memanggil Plugin - dompdf
require_once '../../../libs/dompdf/autoload.inc.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kasir App - Report</title>

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
        <li class="nav-item">
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
        <h1 class="h2"><i class="fas fa-file-alt"></i> Report</h1>
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
          <a href="<? echo $base ?>./app/pages/transactions/sales.php" class="list-group-item list-group-item-action"><i class="fas fa-money-bill-wave"></i> Sales</a>
          <a href="<? echo $base ?>./app/pages/reports/report.php" class="list-group-item list-group-item-action active"><i class="fas fa-file-alt"></i> Report</a>
        </div>
      </div>
      <div class="col-md-9">

        <div class="card mb-3">
          <div class="card-header">Stock Out</div>
          <div class="card-body">

            <div class="card mb-3">
              <div class="card-body">
                <form id="formInvoiceFilter" onsubmit="return false">
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="tgl_awal">Tanggal Awal</label>
                      <input type="date" class="form-control" id="tgl_awal">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="tgl_akhir">Tanggal Akhir</label>
                      <input type="date" class="form-control" id="tgl_akhir">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="invoice_number">Nomor Invoice</label>
                      <input type="text" class="form-control" id="invoice_number" placeholder="F-xxxxx">
                    </div>
                  </div>
                  <div class="text-right">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="button" class="btn btn-info" onclick="showAllOrFilteredReportData()">Cari</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h1 class="h5 float-left">Table Invoice</h1>
                <button class="btn btn-primary float-right" onclick="printReportPdf();">Print</button>
              </div>
              <div class="card-body">
                <div class="table-responsive-lg">
                  <table class="table table-sm table-bordered" id="reportTable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Total Awal</th>
                        <th scope="col">Total Diskon</th>
                        <th scope="col">Total Akhir</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="reportTableBody">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Modal - Report Detail -->
        <div class="modal fade" id="reportModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="reportModal" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" id="reportDetailModalBody">
              <div class="modal-header">
                <h5 class="modal-title" id="reportModal">Detail Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Invoice : <span id="inv_num"></span></p>
                <p>Tagnggal : <span id="tgl_trans"></span></p>
                <table class="table table-sm table-bordered">
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
                  <tbody id="reportDetailTableBody">
                    <!-- Data Ajax -->
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="printReportPdf();">Print</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <div class=" footer-placeholder" style="height: 50px;">
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
    // Load Data
    window.addEventListener('load', function() {
      showAllOrFilteredReportData()
    });

    // Fungsi untuk print data reports
    function printReportPdf() {
      window.open('reports-pdf.php', '_blank');
      showAllOrFilteredReportData();
    }

    // Fungsi untuk menampilkan detail report melalui modal
    function showReportDetail(id) {
      if (id != null) {
        // Deklasri Variabel
        var http = new XMLHttpRequest();
        var res, req;

        req = `id=${id}`;

        http.onreadystatechange = function() {
          // Cek Status response
          if (this.readyState == 4 && this.status == 200) {

            // Konversi string response ke format json
            res = JSON.parse(this.responseText);

            if (res.status) {
              // Deploy Response
              document.querySelector("#reportDetailModalBody #inv_num").innerHTML = res.data.invoice_number;
              document.querySelector("#reportDetailModalBody #tgl_trans").innerHTML = res.data.tanggal_transaksi;
              document.querySelector("#reportDetailModalBody #reportDetailTableBody").innerHTML = res.response;
              // Tambah Attribut pada tpmbol print dalam modal detail invoice
              //// let printButton = document.querySelector('#reportDetailModalBody #printDetailInvoiceBtn');
              //// let NewAttribut = document.createAttribute('onclick');
              //// NewAttribut.value = `printReports('${res.data.invoice_number}')`;
              //// printButton.setAttributeNode(NewAttribut);
              $('#reportModal').modal('show');
            } else {
              // Error Handling
              alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
            }
          }
        };
        // Mengirim Request
        http.open("GET", "display-detail-report.php?" + req, true);
        http.send();
      }
    }

    // Fungsi untuk menampilkan All atau Filtered Invoice data list - AJAX Request
    function showAllOrFilteredReportData() {
      // Deklasri Variabel
      var http = new XMLHttpRequest();
      var res, req;

      // Mengambil input filter
      const dataFilter = {
        "tgl_awal": document.querySelector('#formInvoiceFilter #tgl_awal') ? document.querySelector('#formInvoiceFilter #tgl_awal').value : 0,
        "tgl_akhir": document.querySelector('#formInvoiceFilter #tgl_akhir') ? document.querySelector('#formInvoiceFilter #tgl_akhir').value : 0,
        "inv_num": document.querySelector('#formInvoiceFilter #invoice_number') ? document.querySelector('#formInvoiceFilter #invoice_number').value : 0
      }

      // Menyiapkan Request
      req = `?tgl_awal=${dataFilter.tgl_awal}&tgl_akhir=${dataFilter.tgl_akhir}&inv_num=${dataFilter.inv_num}`;

      http.onreadystatechange = function() {
        // Cek Status response
        if (this.readyState == 4 && this.status == 200) {

          // Konversi string response ke format json
          res = JSON.parse(this.responseText);

          if (res.status) {
            // Deploy Response
            document.getElementById("reportTableBody").innerHTML = res.response;

            // Plugin Datatables
            $('#reportTable').DataTable({
              retrieve: true,
              searching: false
            });

          } else {
            // Error Handling
            alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
          }
        }
      };
      // Mengirim Request
      http.open("GET", "display-report-table.php" + req, true);
      http.send();
    }
  </script>
</body>

</html>