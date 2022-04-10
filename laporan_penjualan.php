<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 20;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM obat";
$pageQry = $koneksidb->query($pageSql);
$jml   = $pageQry->num_rows;
$max   = ceil($jml / $row);
?>
<ol class="breadcrumb pull-right">
  <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
  <li class="breadcrumb-item active">Laporan Penjualan</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Laporan Penjualan <small>Laporan penjualan keseluruhan</small></h1>

<div class="panel panel-inverse">
  <div class="panel-body">
    <table id="data-table-default" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th width="" align="center" bgcolor="#CCCCCC"><strong>No</strong></th>
          <th width="" bgcolor=""><strong>Tanggal</strong></th>
          <th width="" bgcolor=""><strong>No. Penjualan </strong></th>
          <th width="" bgcolor=""><strong>Pelanggan </strong></th>
          <th width="" bgcolor=""><strong>No. Telepon </strong></th>
          <th width="" bgcolor=""><strong>Tunai/Kredit </strong></th>
          <?php /*<th width="" align="" bgcolor="#CCCCCC"><strong>Tools</strong></th>               */ ?>
        </tr>
      </thead>
      <tbody>
        <?php
        // TODO: Perintah untuk menampilkan Semua Daftar Transaksi Penjualan
        $mySql = "SELECT * FROM penjualan ORDER BY no_penjualan DESC ";
        $myQry = $koneksidb->query($mySql);
        $nomor = $hal;
        while ($myData = $myQry->fetch_assoc()) {
          $nomor++;
          // TODO:  Membaca Kode Penjualan/ Nomor transaksi
          $noNota = $myData['no_penjualan'];
        ?>
          <tr>
            <td><?php echo $nomor; ?></td>
            <td><b><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></b></td>
            <td><b><?php echo $myData['no_penjualan']; ?></b></td>
            <td><?php echo $myData['pelanggan']; ?></td>
            <td><?php echo $myData['no_telepon']; ?></td>
            <td><?php echo $myData['bayar']; ?></td><?php /*
      <td align="center"><a href="cetak/penjualan_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td> */ ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>