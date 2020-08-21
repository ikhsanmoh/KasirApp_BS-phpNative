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
  <title>Kasir App - Products</title>

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
        <li class="nav-item active">
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
        <h1 class="h2"><i class="fab fa-product-hunt"></i> Products - Items</h1>
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
          <a href="<? echo $base ?>./app/pages/products/product.php" class="list-group-item list-group-item-action active"><i class="fab fa-product-hunt"></i> Products</a>
          <a href="<? echo $base ?>./app/pages/transactions/sales.php" class="list-group-item list-group-item-action"><i class="fas fa-money-bill-wave"></i> Sales</a>
          <a href="<? echo $base ?>./app/pages/reports/report.php" class="list-group-item list-group-item-action"><i class="fas fa-file-alt"></i> Report</a>
        </div>
      </div>
      <div class="col-md-9">

        <div class="card mb-3">
          <div class="card-header">Edit Product</div>
          <div class="card-body">

            <?php 
              // Memanggil Koneksi
              require_once "../../../config/koneksi.php";

              // Mengambil id dari URL
              $id = $_GET['id']; 

              // Query untuk mengambil data produk dari database
              $query_1 = "SELECT 
                          id_produk, tb_products.id_kat, nama, nama_kat, stok, harga
                        FROM 
                          tb_products 
                        INNER JOIN 
                          tb_categories 
                        ON 
                          tb_products.id_kat = tb_categories.id_kat
                        WHERE
                          id_produk LIKE '$id'";
              
              // Eksekusi query 1
              $sql_1 = mysqli_query($koneksi, $query_1);
              $data = mysqli_fetch_assoc($sql_1);

              // Mengecek Status Query
              if ( !mysqli_num_rows($sql_1) ) {
                die("Id Tidak Ditemukan!");
              }

              // Query untuk mengambil data kategori dari database
              $query_2 = "SELECT id_kat, nama_kat FROM tb_categories";

              // Eksekusi query 2
              $sql_2 = mysqli_query($koneksi, $query_2);
            ?>

            <?php if ( isset($_GET['status']) && $_GET['status'] == "err_01") : ?>
                              
              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Nama Produk</strong> sudah ada!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>

            <?php endif; ?>

            <form class="w-75 mx-auto" action="<? echo $base; ?>app/pages/products/proses-edit-product.php" method="post">
              <input type="hidden" name="id_produk" value="<?php echo $data['id_produk'] ?>">
              <input type="hidden" name="nama_lama" value="<?php echo $data['nama'] ?>">
              <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" class="form-control" id="nama" name="nama_baru" value="<?php echo $data['nama'] ?>" required>
              </div>
              <div class="form-group">
                <label for="kat">Kategori</label>
                <select class="custom-select" id="kat" name="kategori">
                  <option value="0">-- Pilih --</option>
                  <?php
                    foreach ($sql_2 as $dataKategori) {
                      // $select = ($dataKategori['id_kat'] == $data['id_kat']) ? "selected" : "";
                      echo "<option value=".$dataKategori['id_kat'].">". ucfirst($dataKategori['nama_kat']) ."</option>";  
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $data['harga'] ?>" required>
              </div>
              <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $data['stok'] ?>">
              </div>

              <div class="form-group float-right">
                <a href="<? echo $base; ?>app/pages/products/product.php" role="button" class="btn btn-danger">Cancel</a>
                <input type="submit" class="btn btn-success" name="form_edit_product">
              </div>
            </form>

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
  <script src="<? echo $base ?>./scripts/jquery-3.5.1.min.js"></script>
  
  <!-- Bootstrap Core JS -->
  <script src="<? echo $base ?>./scripts/bootstrap.min.js"></script>
  
  <!-- Plugin Datatables Core JS -->
  <script src="<? echo $base ?>./scripts/datatables.min.js"></script>

</body>
</html>