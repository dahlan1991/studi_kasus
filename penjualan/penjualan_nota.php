<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Baca noNota dari URL
if (isset($_GET['noNota'])) {
  $noNota = $_GET['noNota'];

  // Perintah untuk mendapatkan data dari tabel penjualan
  $mySql = "SELECT penjualan.*, petugas.nm_petugas FROM penjualan
				LEFT JOIN petugas ON penjualan.kd_petugas=petugas.kd_petugas 
				WHERE no_penjualan='$noNota'";
  $myQry = mysqli_query($koneksidb, $mySql) or die(mysqli_error($koneksidb));
  $kolomData = mysqli_fetch_array($myQry);
} else {
  echo "Nomor Nota (noNota) tidak ditemukan";
  exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Cetak Nota Penjualan Obat - <?php echo $ambil['nm_toko']; ?></title>
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
  <!--<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>-->
</head>

<body onLoad="window.print()">
  <table border="1" class="table-list" width="430" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td height="87" colspan="5" align="center">
        <strong><?php echo $ambil['nama_cv']; ?></strong><br />
        <strong><?php echo $ambil['nm_toko']; ?></strong><br />
        <?php echo $ambil['alamat_toko']; ?><br>
        HP. : <?php echo $ambil['no_telepon']; ?> / <?php echo $ambil['no_telepon_2']; ?>
      </td>
    </tr>
    <tr>
      <td colspan="2"><strong>No Nota :</strong> <?php echo $kolomData['no_penjualan']; ?></td>
      <td colspan="3" align="right"> <?php echo IndonesiaTgl($kolomData['tgl_penjualan']); ?></td>
    </tr>
    <tr>
      <td width="32" bgcolor="#F5F5F5"><strong>No</strong></td>
      <td width="193" bgcolor="#F5F5F5"><strong>Daftar Barang </strong></td>
      <td width="55" align="right" bgcolor="#F5F5F5"><strong>Harga@</strong></td>
      <td width="27" align="right" bgcolor="#F5F5F5"><strong>Qty</strong></td>
      <td width="97" align="right" bgcolor="#F5F5F5"><strong>Subtotal(Rp) </strong></td>
    </tr>
    <?php
    # Baca variabel
    $totalBayar = 0;
    $jumlahObat = 0;
    $uangKembali = 0;

    # Menampilkan List Item obat yang dibeli untuk Nomor Transaksi Terpilih
    $notaSql = "SELECT penjualan_item.*, obat.nm_obat FROM penjualan_item
          LEFT JOIN obat ON penjualan_item.kd_obat=obat.kd_obat 
          WHERE penjualan_item.no_penjualan='$noNota'
          ORDER BY obat.kd_obat ASC";
    $notaQry = mysqli_query($koneksidb, $notaSql) or die(mysqli_error($koneksidb));
    $nomor  = 0;
    while ($notaData = mysqli_fetch_array($notaQry)) {
      $nomor++;
      $subSotal   = $notaData['jumlah'] * $notaData['harga_jual'];
      $totalBayar  = $totalBayar + $subSotal;
      $jumlahObat = $jumlahObat + $notaData['jumlah'];
    ?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $notaData['kd_obat']; ?>/ <?php echo $notaData['nm_obat']; ?></td>
        <td align="right"><?php echo format_angka($notaData['harga_jual']); ?></td>
        <td align="right"><?php echo $notaData['jumlah']; ?></td>
        <td align="right"><?php echo format_angka($subSotal); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="3" align="right"><strong>Total Belanja (Rp) : </strong></td>
      <td colspan="2" align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
    </tr>
    <tr>
      <td colspan="3" align="right"><strong> PPN : </strong></td>
      <td colspan="2" align="right">10%</td>
    </tr>
    <tr>
      <td colspan="5"><strong>Petugas :</strong> <?php echo $kolomData['nm_petugas']; ?></td>
    </tr>
  </table>
</body>

</html>