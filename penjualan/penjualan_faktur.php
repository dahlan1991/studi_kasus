<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.terbilang.php";

# Baca noNota dari URL
if (isset($_GET['noFaktur'])) {
  $noNota = $_GET['noFaktur'];

  // Perintah untuk mendapatkan data dari tabel penjualan
  $mySql = "SELECT penjualan.*, DATE_ADD(tgl_penjualan, INTERVAL 30 DAY) as jatuh_tempo, petugas.nm_petugas FROM penjualan
				LEFT JOIN petugas ON penjualan.kd_petugas=petugas.kd_petugas 
				WHERE no_penjualan='$noNota'";
  $myQry = $koneksidb->query($mySql);
  $kolomData = $myQry->fetch_assoc();
} else {
  echo "Nomor Nota (noNota) tidak ditemukan";
  exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Cetak Faktur Penjualan Obat - <?php echo $ambil['nm_toko']; ?></title>
  <link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
  <!--<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script> -->
</head>

<body onLoad="window.print()">
  <table border="0" class="table-list" width="90%" cellspacing="0" cellpadding="2">
    <tr>
      <td height="87" colspan="4" align="center">
        <u><strong>FAKTUR PENJUALAN</strong></u><br>
        <label style="font-size:12px"> No. Faktur <?php echo $noNota;
                                                  echo IndonesiaTgl($kolomData['tgl_penjualan']); ?></label>
      </td>
    </tr>
    <tr>
      <td width="10%">
        <center><img src="../assets/img/logo.png" alt="" width="100" height="100"> </center>
      </td>
      <td height="87" colspan="" width="45%">
        <strong><?php echo $ambil['nama_cv']; ?></strong><br />
        <strong><?php echo $ambil['nm_toko']; ?></strong><br />
        <label><?php echo $ambil['alamat_toko']; ?></label><br />
        <label>HP. <?php echo $ambil['no_telepon']; ?> / <?php echo $ambil['no_telepon_2']; ?></label><br>
      </td>
      <td colspan="">
        Tanggal : <br> <?php echo IndonesiaTgl($kolomData['tgl_penjualan']); ?>
        <br>
        Tempo : <br> --
        <br>
        Jatuh Tempo : <br> -- <?php //echo IndonesiaTgl($kolomData['jatuh_tempo']); 
                              ?>
      </td>
      <?php
      # Menampilkan List Item obat yang dibeli untuk Nomor Transaksi Terpilih
      $petugasSql = "SELECT penjualan_item.*, penjualan.* FROM penjualan_item
            LEFT JOIN penjualan ON penjualan_item.no_penjualan=penjualan.no_penjualan 
            WHERE penjualan_item.no_penjualan='$noNota'
            ";
      $petugasQry = $koneksidb->query($petugasSql);

      $petugasData = $petugasQry->fetch_assoc();

      $diskon = $petugasData['diskon'];
      $diskon2 = $petugasData['diskon'] / 100;

      ?>
      <td height="87" colspan="" align="left">
        <strong>Kepada Yth. </strong><br />
        <?php echo $petugasData['pelanggan']; ?><br>
        <label>HP. <?php echo $petugasData['no_telepon']; ?></label><br> <br>
        <label for="">Pembayaran : </label>
        <label style="font-size:22px"><b>TUNAI</b></label>
      </td>
    </tr>
  </table><br>
  <table border="1" class="table-list" width="90%" cellspacing="0" cellpadding="2">
    <tr border="1">
      <td width="32" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="193" bgcolor="#CCCCCC"><strong>Daftar Barang </strong></td>
      <td width="27" align="right" bgcolor="#CCCCCC"><strong>Qty</strong></td>
      <td width="55" align="right" bgcolor="#CCCCCC"><strong>Harga@</strong></td>
      <td width="97" align="right" bgcolor="#CCCCCC"><strong>Subtotal(Rp) </strong></td>
    </tr>
    <?php
    # Baca variabel
    $totalBayar = 0;
    $jumlahObat = 0;
    //$uangKembali = 0;
    $ppn = 10 / 100;

    # Menampilkan List Item obat yang dibeli untuk Nomor Transaksi Terpilih
    $notaSql = "SELECT penjualan_item.*, obat.nm_obat FROM penjualan_item
			LEFT JOIN obat ON penjualan_item.kd_obat=obat.kd_obat
      LEFT JOIN penjualan ON penjualan_item.no_penjualan=penjualan.no_penjualan  
			WHERE penjualan_item.no_penjualan='$noNota'
			ORDER BY obat.kd_obat ASC";
    $notaQry = $koneksidb->query($notaSql);
    $nomor  = 0;
    while ($notaData = $notaQry->fetch_assoc()) {
      $nomor++;
      $subSotal   = $notaData['jumlah'] * $notaData['harga_jual'];
      $jumlahObat = $jumlahObat + $notaData['jumlah'];
      //$uangKembali= $kolomData['uang_bayar'] - $totalBayar;
      //$diskon = $notaData['diskon'];


      $totalBayar  = $totalBayar + $subSotal;

      $hitungPPN = $totalBayar * $ppn;
      $hargraDiskon = $totalBayar * $diskon2;

      $grandtotal = $totalBayar - $hargraDiskon + $hitungPPN;

    ?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $notaData['nm_obat']; ?></td>

        <td align="right"><?php echo $notaData['jumlah']; ?></td>
        <td align="right"><?php echo format_angka($notaData['harga_jual']); ?></td>
        <td align="right"><?php echo format_angka($subSotal); ?></td>
      </tr>
    <?php } ?>

    <tr>
      <td colspan="4" align="right"><strong>Subtotal (Rp) : </strong></td>
      <td colspan="2" align="right" bgcolor="#F5F5F5"><b><?php echo format_angka($totalBayar); ?></b></td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>PPN : </strong></td>
      <td colspan="2" align="right" bgcolor="#F5F5F5"><b>10%</b></td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>Diskon : </strong></td>
      <td colspan="2" align="right" bgcolor="#F5F5F5"><b><?php echo $diskon ?>%</b></td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong> Total Belanja (Rp) : </strong></td>
      <td colspan="2" align="right"><b><?php echo format_angka($grandtotal); ?></b></td>
    </tr>
  </table> <br>
  <table border="0" class="table-list" width="90%" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="5"> Terbilang :<label style="font-size:18px"> <i><b><?php echo strtoupper(terbilang($grandtotal)); ?> RUPIAH</b></i> </label> </td>
    </tr>
    <tr>
      <td width="193">*Catatan :
        <br> - Barang yang sudah dibeli tidak dapat ditukar kembali
        <br> - Bayaran dengan tanda giro/cek adalah pembayaran nya sudah <b>LUNAS</b>
      </td>
      <td width="27"></td>
      <td width="27" align="right"></td>
      <td width="55" align="right"></td>
      <td width="97" align="center"><strong>Petugas :</strong> <br> <br> <br> <br> <br> <br>
        <?php echo $kolomData['nm_petugas']; ?>
      </td>
    </tr>
  </table>
</body>

</html>