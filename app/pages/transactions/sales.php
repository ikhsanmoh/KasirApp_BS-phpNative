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
                <form action="" method="post">
                  
                  <!-- <fieldset style="border: 1px solid gray; padding: 20px; border-radius: 20px;"> -->
                  
                  <div class="card">
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="inputAddress">Kode Barang</label>
                          <div class="input-group">
                            <input type="text" class="form-control" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#productModal" type="button">Cari</button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="inputAddress2">Nama Barang</label>
                          <input type="text" class="form-control" id="inputAddress2" value="Asus D2zs" disabled>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-8">
                          <label for="inputCity">Harga Satuan</label>
                          <input type="text" class="form-control" id="inputCity" value="Rp. 15.500.000" disabled>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputState">Diskon</label>
                          <select id="inputState" class="form-control">
                            <option selected>--- Pilih ---</option>
                            <option value="1">10%</option>
                            <option value="2">30%</option>
                            <option value="3">50%</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="input3">Jumlah</label>
                        <input type="number" class="form-control" id="input3" placeholder="Masukan Jumlah Barang">
                      </div>
                      <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                  </div>

                  <!-- </fieldset> -->

                </form>
              </div>

              <div class="col-lg-4">
              
                <div class="card">
                  <div class="card-body">
                    <h1 class="h5">Invoice <small class="font-weight-bold">00191</small></h1>
                    <h1 class="h4 font-weight-bold">Rp. 15.000.000</h1>
                  </div>
                </div>

              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">

                <div class="card">
                  <div class="card-body">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Code</th>
                          <th scope="col">Product Name</th>
                          <th scope="col">Price</th>
                          <th scope="col">Qty</th>
                          <th scope="col">Sub Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>KD001</td>
                          <td>ASUS D21</td>
                          <td>Rp. 15.500.000</td>
                          <td>2</td>
                          <td>Rp. 31.000.000</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
            </div>

            <div class="row mb-3">
            
              <div class="col-md-8">

                <div class="card">
                  <div class="card-body">
                    <form action="" method="post">
                      
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="input1">Total</label>
                          <input type="number" class="form-control" id="input1" value="Rp. 15.500.000" disabled>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="input2">Diskon</label>
                          <input type="number" class="form-control" id="input2" value="Rp. 500.000" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="input3">Total Akhir</label>
                        <input type="number" class="form-control" id="input3" value="Rp. 15.000.000" disabled>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputAddress4">Bayar</label>
                          <input type="number" class="form-control" id="inputAddress4">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="input5">Kembalian</label>
                          <input type="number" class="form-control" id="input5" value="" disabled>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary">Submit</button>

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
                <th scope="col">Code</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>KD001</td>
                <td>Asus D12</td>
                <td>Rp. 15.500.000</td>
                <td>30</td>
                <td>
                  <button type="button" class="btn btn-sm btn-info"><i class="fas fa-check"></i> Select</button>
                </td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>KD002</td>
                <td>MSI 2PL</td>
                <td>Rp. 13.800.000</td>
                <td>20</td>
                <td>
                  <button type="button" class="btn btn-sm btn-info"><i class="fas fa-check"></i> Select</button>
                </td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>KD003</td>
                <td>Hardisk Seagate 500GB</td>
                <td>Rp. 650.000</td>
                <td>100</td>
                <td>
                  <button type="button" class="btn btn-sm btn-info"><i class="fas fa-check"></i> Select</button>
                </td>
              </tr>
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
    // Datatables Plugin - Membuat fungsi yang dieksekusi secara continuously
    setInterval(function() {
      $(document).ready( function () {
        $('#productModalTable').DataTable();
      });
    }, 200); // Waktu interval, eg. 1000 = 1 detik
  </script>

</body>
</html>