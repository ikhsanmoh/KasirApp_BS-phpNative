<?php

/**
 *TODO : Fix beberapa Modul yang kurang sempurna
 *! Terdapat beberapa halaman backend yang blum terproteksi .
 *! Ada potensi error pada modul kategori jika melakukan penghapusan kategori yang terattach ke produk yang tersedia.
 * 
 *TODO : Tambah beberapa Fitur dan Pengoptimalan App
 *! Menambah pengaturan profil user pada applikasi.
 *! Membuat authorization berdasarkan role admin dan kasir.
 *! Ubah semua CRUD menjadi AJAX Request.
 *! Buat fungsi untuk blok kode yang berulang pada JS & PHP Section.
 *! Buat fungsi atau partial untuk html yang berulang.
 *! Perbaiki Notif "Input Success" pada modul sales.
 *! Tingkatkan keamanan database dengan menggunakan prepare func pada tiap query.
 *! Tingkatkan keamana URL dengan menggunakan .htaccess  untuk menyembunyikan real URL.
 *! Tingkatkan SEO App.
 */


// Mengambil Base URL
include "./config/url-base.php";

// Mengecek Status Login Session
require_once "./app/auth/login-session.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kasir App - Dashboard</title>

  <!-- Bootstrap Core CSS -->
  <link rel="stylesheet" href="./styles/bootstrap.min.css">

  <!--Font Awsome Core CSS -->
  <link rel="stylesheet" href="./styles/fontawsome/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./styles/custom.css">

  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"> -->

  <!-- Plugin Jquery - Treeview Menu CSS -->
  <!-- <link rel="stylesheet" href="./styles/jquery.treemenu.min.css"> -->

  <!-- Google Fonts -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"> -->

  <!-- Material Design Bootstrap -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet"> -->

</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Kasir App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="./index.php">Dashboard <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./app/pages/users/user.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./app/pages/products/product.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./app/pages/transactions/sales.php">Sales</a>
        </li>
      </ul>
      <ul class="navbar-nav mr-2">

        <!-- Includes Navbar Kanan -->
        <? include "./app/includes/navbar-right.php" ?>

      </ul>
    </div>
  </nav>

  <div class="custom-header bg-secondary">
    <div class="container">
      <div class="row">
        <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
      </div>
    </div>
  </div>

  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="list-group mb-3">
          <a href="./index.php" class="list-group-item list-group-item-action active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="./app/pages/users/user.php" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Users</a>
          <a href="./app/pages/products/category.php" class="list-group-item list-group-item-action"><i class="fas fa-tag"></i> Product Categories</a>
          <a href="./app/pages/products/product.php" class="list-group-item list-group-item-action"><i class="fab fa-product-hunt"></i> Products</a>
          <a href="./app/pages/transactions/sales.php" class="list-group-item list-group-item-action"><i class="fas fa-money-bill-wave"></i> Sales</a>
          <a href="./app/pages/reports/report.php" class="list-group-item list-group-item-action"><i class="fas fa-file-alt"></i> Report</a>
        </div>
      </div>
      <div class="col-md-9">

        <div class="card mb-3">

          <div class="card-header">
            Site Overview
          </div>
          <div class="card-body" id="siteOverviewBody">
            <div class="row">

              <div class="col-md-4">
                <div class="card bg-light">
                  <div class="card-body text-center">
                    <h2>
                      <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-people-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                      </svg> <span id="users"></span>
                    </h2>
                    <h4 class="card-title">Users</h4>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card bg-light">
                  <div class="card-body text-center">
                    <h2><i class="fas fa-tags"></i> <span id="categories"></span>
                    </h2>
                    <h4 class="card-title">Categories</h4>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card bg-light">
                  <div class="card-body text-center">
                    <h2>
                      <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                      </svg> <span id="products"></span>
                    </h2>
                    <h4 class="card-title">Products</h4>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            Latest Product
          </div>
          <div class="card-body" id="latestProductBody">
            <div class="table-responsive-lg">
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Stok</th>
                  </tr>
                </thead>
                <tbody id="latestProductTable">
                  <!-- Data Latest Product -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

    </div>
    </div>
  </main>

  <footer class="footer mt-auto py-3 bg-dark fixed-bottom text-center">
    <div class="container">
      <span class="text-muted">&copy; Ikhsan Mohamad 2020</span>
    </div>
  </footer>
  <!-- Jquery Core JS -->
  <script src="./scripts/jquery-3.5.1.min.js"></script>

  <!-- Bootstrap Core JS -->
  <script src="./scripts/bootstrap.min.js"></script>

  <!-- Main JS -->
  <script>
    window.addEventListener('load', function() {
      showSiteOverview();
      showLatestProduct();
    });

    // Fungsi untuk Load Latest Product - AJAX
    function showSiteOverview() {
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
            document.querySelector("#siteOverviewBody #users").innerHTML = res.data.jumlah_users ? res.data.jumlah_users : "";
            document.querySelector("#siteOverviewBody #categories").innerHTML = res.data.jumlah_kategori ? res.data.jumlah_kategori : "";
            document.querySelector("#siteOverviewBody #products").innerHTML = res.data.jumlah_produk ? res.data.jumlah_produk : "";
          } else {
            // Error Handling
            alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
          }
        }
      };
      // Mengirim Request
      http.open("GET", "app/request/display-siteoverview.php", true);
      http.send();
    }

    // Fungsi untuk Load Latest Product - AJAX
    function showLatestProduct() {
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
            document.querySelector("#latestProductBody #latestProductTable").innerHTML = res.response ? res.response : "";
          } else {
            // Error Handling
            alert("Terjadi kesalahan pada Server. Pesan Error : " + res.message);
          }
        }
      };
      // Mengirim Request
      http.open("GET", "app/request/display-latest-product.php", true);
      http.send();
    }
  </script>

</body>

</html>