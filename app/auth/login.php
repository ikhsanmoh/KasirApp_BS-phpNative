<?php
  session_start();
  if ( isset($_SESSION['user']) ) {
    header('location: ../../index.php'); 
  }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <link rel="stylesheet" href="../../styles/bootstrap.min.css">
  <link rel="stylesheet" href="../../styles/login.css">
</head>
<body class="text-center">

  <form class="form-signin" action="proses-login.php" method="post">

    <h2 class="h2 font-weight-bold">Kasir Application</h2>
    <img class="mb-4" src="../../assets/img/kasir.png" alt="logo" width="72" height="72">
    <h2 class="h4 mb-3 font-weight-normal">Silahkan Login</h2>
    <label for="username" class="sr-only">Username</label>
    <input type="email" id="username" class="form-control" name="username" placeholder="Email" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
    <input class="btn btn-primary btn-block" type="submit" value="Masuk" name="login_form">
    <div class="mt-2">
      <!-- <p class="mb-0"><a href="forgot-password.php" class="small">Lupa Password?</a></p> -->
      <!-- <a href="daftar.php" class="small">Daftar</a> -->
    </div>

    <?php if ( isset($_GET['status']) ) : ?>

    <div id="alert" class="alert alert-danger" role="alert">  
      <?php
        if ($_GET['status'] == 'err_usernm') {
          echo "Username yang Anda masukan tidak terdaftar!";
        } elseif ($_GET['status'] == 'err_pass') {
          echo "Password yang Anda masukan salah!";
        }
      ?>
    </div>

    <?php endif; ?>

    <p class="mt-5 mb-3 text-muted">&copy; Ikhsan Mohamad 2020</p>

  </form>

</body>
</html>