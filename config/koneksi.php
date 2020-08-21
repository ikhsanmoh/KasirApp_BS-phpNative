<?php

  $host = "localhost:3306";
  // $port = "3306";
  $username = "root";
  $pass = "";
  $dbname = "ujikom_kasirApp";

  $koneksi = new mysqli($host, $username, $pass, $dbname);

  if ($koneksi->connect_errno) {
    echo "Gagal Terhubung ke MySQL: (" . $koneksi->connect_errno . ") " . $koneksi->connect_error;
  }

?>