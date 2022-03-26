<?php
if (isset($_GET['page'])) {
  $page = $_GET['page'];

  switch ($page) {
    case 'Barang-Data';
      include_once "barang_data.php";
      break;

    case 'Barang-Add';
      include_once "barang_add.php";
      break;

    case 'Barang-Edit';
      include_once "barang_edit.php";
      break;

    case 'Barang-Delete';
      include_once "barang_delete.php";
      break;

    case 'Laporan-Penjualan';
      include_once "laporan_penjualan.php";
      break;

    case 'Laporan-Penjualan-Periode';
      include_once "laporan_penjualan_periode.php";
      break;

    case 'Laporan-Keuntungan-Periode';
      include_once "laporan_keuntungan_periode.php";
      break;

    case 'Petugas-Data';
      include_once "petugas_data.php";
      break;

    case 'Petugas-Add';
      include_once "petugas_add.php";
      break;

    case 'Petugas-Edit';
      include_once "petugas_edit.php";
      break;

    case 'Petugas-Delete';
      include_once "petugas_delete.php";
      break;

    case 'Toko';
      include_once "toko.php";
      break;
    case 'Laporan-Obat';
      include_once "laporan_obat.php";
      break;

    default;
      "<center><h3 style='color:white;'>Maaf. Halaman tidak di temukan !</h3></center>";
      break;
  }
} else {
  include_once 'dashboard.php';
}
