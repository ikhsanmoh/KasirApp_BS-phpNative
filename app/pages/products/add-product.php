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
          <div class="card-header">Add Product</div>
          <div class="card-body">

            <form class="w-75 mx-auto" action="<? echo $base; ?>app/pages/products/proses-add-product.php" method="post">
              <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category">
              </div>
              <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
              </div>

              <div class="form-group float-right">
                <a href="<? echo $base; ?>app/pages/products/product.php" role="button" class="btn btn-danger">Cancel</a>
                <input type="submit" class="btn btn-success" name="form_add_product">
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