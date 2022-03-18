<?php

# Koneksi ke Web Server Lokal
$myHost  = "localhost";
$myUser  = "root";
$myPass  = "";
$myDbs  = "apotek"; // nama database, disesuaikan dengan database di MySQL

# Konek ke Web Server Lokal
$koneksidb  = new mysqli($myHost, $myUser, $myPass, $myDbs);
if (!$koneksidb) {
  echo "Failed Connection !";
}

# Memilih database pd MySQL Server
// mysqli_select_db($myDbs) or die("Database not Found !");

# Menampilkan data toko
// $toko = mysqli_query($koneksidb, "SELECT * FROM toko WHERE id=1");
// $ambil = mysqli_fetch_array($toko);
$toko = $koneksidb->query("SELECT * FROM toko WHERE id=1");
$ambil = $toko->fetch_assoc();

# Mengambil kode faktur yang berada di database
$faktur = $ambil['kode_faktur'];

?>
