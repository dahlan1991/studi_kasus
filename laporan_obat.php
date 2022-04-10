<?php
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 25;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM obat";
$pageQry = $koneksidb->query($pageSql);
$jml   = $pageQry->num_rows;
$max   = ceil($jml / $row);
?>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Laporan Data Obat</h1>
  </div>
  <!-- /.col-lg-12 -->
</div>


<div class="dataTable-wrapper">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="1" cellpadding="3">
      <tr>
        <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="55" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="315" bgcolor="#CCCCCC"><strong>Nama Obat</strong></td>
        <td width="80" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
        <td width="35" align="right" bgcolor="#CCCCCC"><strong>Stok</strong></td>
        <td width="264" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
      </tr>
      <?php
      # SQL Menampilkan data semua obat
      $mySql   = "SELECT * FROM obat ORDER BY kd_obat ASC LIMIT $hal, $row";
      $myQry   = $koneksidb->query($mySql);
      $nomor  = $hal;
      while ($myData = $myQry->fetch_assoc()) {
        $nomor++;
      ?>
        <tr>
          <td> <?php echo $nomor; ?> </td>
          <td> <?php echo ucwords($myData['kd_obat']); ?> </td>
          <td> <?php echo $myData['nm_obat']; ?> </td>
          <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
          <td align="right"> <?php echo $myData['stok']; ?> </td>
          <td><?php echo $myData['keterangan']; ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="3" bgcolor="#CCCCCC"><strong>Jumlah Data :</strong> <button class="btn btn-sm btn-light"><?php echo $jml; ?></button> </td>
        <td colspan="3" align="right" bgcolor="#CCCCCC">
          <strong>Halaman ke :</strong>
          <?php
          for ($h = 1; $h <= $max; $h++) {
            $list[$h] = $row * $h - $row;
            echo " <a class='btn btn-sm btn-light' href='?page=Laporan-Obat&hal=$list[$h]'>$h</a> ";
          }
          ?>
        </td>
      </tr>
    </table>
  </div>
</div>