<? if ( isset($_SESSION['user']) ) : ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><? echo $_SESSION['user']; ?></a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
      <a class="dropdown-item" href="./app/auth/logout.php?logout=true">Logout</a>
    </div>
  </li>
<? else : ?>
  <li class="nav-item">
    <a class="nav-link" href="./app/auth/login.php">Login</a>
  </li>
<? endif; ?>