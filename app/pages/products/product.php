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
          <div class="card-header">Header</div>
          <div class="card-body">

            <div class="p-2 mb-2">
              <a class="btn btn-md btn-primary" href="<? echo $base ?>./app/pages/products/add-product.php" role="button">Add New Product</a>
            </div>
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Code</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Category</th>
                  <th scope="col">Stock</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>KD001</td>
                  <td>Asus A3</td>
                  <td>Laptop</td>
                  <td>10</td>
                  <td>
                    <a class="btn btn-sm btn-info" href="<? echo $base ?>./app/pages/products/add-product.php" role="button">Edit</a>
                    <a class="btn btn-sm btn-danger" href="#" role="button">Delete</a> 
                  </td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>KD002</td>
                  <td>MSI 2PL</td>
                  <td>Laptop</td>
                  <td>5</td>
                  <td>
                    <a class="btn btn-sm btn-info" href="<? echo $base ?>./app/pages/products/edit-product.php" role="button">Edit</a>
                    <a class="btn btn-sm btn-danger" href="#" role="button">Delete</a> 
                  </td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>KD003</td>
                  <td>Seagate 500GB</td>
                  <td>Hardisk</td>
                  <td>50</td>
                  <td>
                    <a class="btn btn-sm btn-info" href="<? echo $base ?>./app/pages/products/edit-product.php" role="button">Edit</a>
                    <a class="btn btn-sm btn-danger" href="#" role="button">Delete</a> 
                  </td>
                </tr>
              </tbody>
            </table>

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