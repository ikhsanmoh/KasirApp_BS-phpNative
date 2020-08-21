<?php

  /* Fungsi Generate Invoice Number
   * -------------------------------------------------------------------------
   * Deskripsi Fungsi
   * 1. Parameter 1 untuk memasukan nomor invoice utama
   * 2. Parameter 2 untuk menentukan panjang dari nomor invoice
   * 3. parameter 3 untuk men-set nilai prefix dari nomor invoice
   * 4. Nilai return hanya nomor invoice saja jika parameter 3 dikosongkan
   * 5. Nilai return akan selalu ber tipe string
  */
  function invNumGen($invNum = 1, $len = 5, $prefix = null){
    
    // Menyiapkan Nomor Invoice (panjang nomor inv, Angka sisa dibelakang nomor inv)
    $invoice_number = sprintf("%0".$len."d", $invNum);

    // Cek jika prefix di set
    if ($prefix) {
      // Menggabung Prefix dengan Nomor Invoice
      $invoice_number = $prefix.$invoice_number;
    }

    // Mengembalikan Hasil
    return $invoice_number;
  }

?>