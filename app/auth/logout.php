<?php

  if ( $_GET['logout'] == "true" ) {
    
    session_start();
    session_destroy();

    header('location: login.php');

  } else {

    header('location: ../../index.php');
  
  }

?>