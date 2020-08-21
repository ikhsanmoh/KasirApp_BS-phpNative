<?php

  // Membuat Status Http
  $httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';

  // Menyapkan Nama Host
  $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
  
  // Membuat Base Path
  $base = $httpProtocol.'://'.$host.'/My%20File/ujikom/latihan/KasirApp_BS-phpNative/';

?>