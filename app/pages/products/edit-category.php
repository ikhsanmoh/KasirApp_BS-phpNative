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
        <h1 class="h2"><i class="fas fa-tag"></i> Products - Categories</h1>
      </div>
    </div>
  </div>

  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="list-group mb-3">
          <a href="<? echo $base ?>./index.php" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="<? echo $base ?>./app/pages/users/user.php" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Users</a>
          <a href="<? echo $base ?>./app/pages/products/category.php" class="list-group-item list-group-item-action active"><i class="fas fa-tag"></i> Product Categories</a>
          <a href="<? echo $base ?>./app/pages/products/product.php" class="list-group-item list-group-item-action"><i class="fab fa-product-hunt"></i> Products</a>
          <a href="<? echo $base ?>./app/pages/transactions/sales.php" class="list-group-item list-group-item-action"><i class="fas fa-money-bill-wave"></i> Sales</a>
          <a href="<? echo $base ?>./app/pages/reports/report.php" class="list-group-item list-group-item-action"><i class="fas fa-file-alt"></i> Report</a>
        </div>
      </div>
      <div class="col-md-9">

        <div class="card mb-3">
          
          <div class="card-header">Edit Category</div>
            <div class="card-body">

            <?php 
              // Memanggil Koneksi
              require_once "../../../config/koneksi.php";

              // Mengambil id dari URL
              $id = $_GET['id']; 

              // Query untuk mengambil data id dari database
              $query_1 = "SELECT * FROM tb_categories WHERE id_kat LIKE '$id'";
              
              // Eksekusi query 1
              $sql_1 = mysqli_query($koneksi, $query_1);
              $data = mysqli_fetch_assoc($sql_1);

              // Mengecek Status Query
              if ( !mysqli_num_rows($sql_1) ) {
                die("Id Tidak Ditemukan!");
              }
            ?>

            <?php if ( isset($_GET['status']) && $_GET['status'] == "err_01") : ?>
                
              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Nama Kategori</strong> sudah ada!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>

            <?php endif; ?>
  
              <form class="w-75 mx-auto" action="<? echo $base; ?>app/pages/products/proses-edit-category.php" method="post">
                <input type="hidden" name="id" value="<? echo $data['id_kat']; ?>">
                <input type="hidden" name="nama_lama" value="<? echo $data['nama_kat']; ?>">
                <div class="form-group">
                  <label for="nama">Nama Kategori</label>
                  <input type="text" class="form-control" id="nama" name="nama_baru" value="<? echo $data['nama_kat']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="desc">Deskripsi Kategori</label>
                  <textarea class="form-control" id="desc" name="deskripsi" rows="3"><? echo $data['deskripsi_kat']; ?></textarea>
                </div>
                <div class="form-group float-right">
                  <a href="<? echo $base; ?>app/pages/products/category.php" role="button" class="btn btn-danger">Cancel</a>
                  <input type="submit" class="btn btn-success" name="form_edit_category">
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