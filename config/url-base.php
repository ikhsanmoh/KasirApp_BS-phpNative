<?php

  // Membuat Status Http
  $httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
  
  // Membuat Base Path
  $base = $httpProtocol.'://'.$_SERVER['HTTP_HOST'].'/My%20File/ujikom/latihan/KasirApp_BS-phpNative/';

?>