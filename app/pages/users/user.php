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
  <title>Kasir App - Users</title>

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
        <li class="nav-item active">
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
        <div class="col-md-12">
          <h1 class="h2"><i class="fas fa-users"></i> Users</h1>
        </div>
      </div>
    </div>
  </div>

  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="list-group mb-3">
          <a href="<? echo $base ?>./index.php" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="<? echo $base ?>./app/pages/users/user.php" class="list-group-item list-group-item-action active"><i class="fas fa-users"></i> Users</a>
          <a href="<? echo $base ?>./app/pages/products/category.php" class="list-group-item list-group-item-action"><i class="fas fa-tag"></i> Product Categories</a>
          <a href="<? echo $base ?>./app/pages/products/product.php" class="list-group-item list-group-item-action"><i class="fab fa-product-hunt"></i> Products</a>
          <a href="<? echo $base ?>./app/pages/transactions/sales.php" class="list-group-item list-group-item-action"><i class="fas fa-money-bill-wave"></i> Sales</a>
          <a href="<? echo $base ?>./app/pages/reports/report.php" class="list-group-item list-group-item-action"><i class="fas fa-file-alt"></i> Report</a>
        </div>
      </div>
      <div class="col-md-9">

        <div class="card mb-3">
          <div class="card-header">Users List</div>
          <div class="card-body">
            <div class="p-2 mb-2">
              <a class="btn btn-md btn-primary" href="<? echo $base ?>./app/pages/users/add-user.php" role="button">Add New User</a>
            </div>

            <?php if (isset($_GET['status']) && $_GET['status'] == "sukses_add") : ?>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-success" role="alert">
                    Berhasil menambah User baru!
                  </div>
                </div>
              </div>

            <?php elseif (isset($_GET['status']) && $_GET['status'] == "gagal_add") : ?>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-danger" role="alert">
                    Gagal menambah User baru!
                  </div>
                </div>
              </div>

            <?php elseif (isset($_GET['status']) && $_GET['status'] == "sukses_update") : ?>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-success" role="alert">
                    Berhasil memperbaharui User!
                  </div>
                </div>
              </div>

            <?php elseif (isset($_GET['status']) && $_GET['status'] == "gagal_update") : ?>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-danger" role="alert">
                    Gagal memperbaharui User!
                  </div>
                </div>
              </div>

            <?php elseif (isset($_GET['status']) && $_GET['status'] == "sukses_delete") : ?>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-success" role="alert">
                    Berhasil menghapus User!
                  </div>
                </div>
              </div>

            <?php elseif (isset($_GET['status']) && $_GET['status'] == "gagal_delete") : ?>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="alert alert-danger" role="alert">
                    Gagal menghapus User!
                  </div>
                </div>
              </div>

            <?php endif; ?>

            <div class="table-responsive-lg">
              <table class="table table-striped table-sm" id="userTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Level</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  // Memanggil Koneksi
                  require_once "../../../config/koneksi.php";

                  $query = "SELECT * FROM tb_users";
                  $sql = mysqli_query($koneksi, $query);
                  $no = 1;

                  $dataSum = mysqli_num_rows($sql);
                  ?>

                  <?php while ($data = mysqli_fetch_assoc($sql)) : ?>

                    <tr>
                      <th scope="row"><?php echo $no++; ?></th>
                      <td><?php echo $data['nama']; ?></td>
                      <td>
                        <?php echo ($data['jenis_kelamin'] == "L") ? 'Laki-laki' : 'Perempuan'; ?>
                      </td>
                      <td><?php echo $data['email']; ?></td>
                      <td><?php echo $data['no_telepon']; ?></td>
                      <td><?php echo $data['level_user']; ?></td>
                      <td>
                        <a href="edit-user.php?id=<?php echo $data['id']; ?>" class="btn btn-info btn-sm" role="button">Edit</a>
                        <a href="proses-delete-user.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" role="button" onclick='return confirm("Yakin Hapus?")'>Delete</a>
                      </td>
                    </tr>

                  <?php endwhile; ?>

                </tbody>
              </table>
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
  <script src="<? echo $base ?>./scripts/jquery-3.5.1.min.js"></script>

  <!-- Bootstrap Core JS -->
  <script src="<? echo $base ?>./scripts/bootstrap.min.js"></script>

  <!-- Plugin Datatables Core JS -->
  <script src="<? echo $base ?>./scripts/datatables.min.js"></script>

  <!-- JS untuk Plugin untuk Filtering -->
  <script>
    // Menghilangkan Pesan Alert dalam beberapa detik
    $('.alert').delay(3000).fadeOut(300);

    // Plugin Pagination dan Filter menggunakan Datatables
    $(document).ready(function() {
      $('#userTable').DataTable();
    });
  </script>

</body>

</html>