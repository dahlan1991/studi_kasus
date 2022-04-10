<?php
include_once "library/inc.seslogin.php";

//TODO: Deklarasi variabel
$filterPeriode = "";
$tglAwal  = "";
$tglAkhir  = "";

//TODO: Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal   = isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-" . date('m-Y');
$tglAkhir   = isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

//TODO: Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
  //TODO:  Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterPeriode = "WHERE ( tgl_penjualan BETWEEN '" . InggrisTgl($tglAwal) . "' AND '" . InggrisTgl($tglAkhir) . "')";
} else {
  //TODO: Membaca data tanggal dari URL, saat Nomor Halaman diklik
  $tglAwal   = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir;

  //TODO: Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterPeriode = "WHERE ( tgl_penjualan BETWEEN '" . InggrisTgl($tglAwal) . "' AND '" . InggrisTgl($tglAkhir) . "')";
}

//TODO:  UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan $filterPeriode";
$pageQry = $koneksidb->query($pageSql);
$jml   = $pageQry->num_rows;
$max   = ceil($jml / $row);
?>

<ol class="breadcrumb pull-right">
  <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
  <li class="breadcrumb-item active">Laporan Penjulan Periode</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Laporan Penjualan <small>Laporan penjualan berdasarkan periode tanggal</small></h1>
<div class="row">
  <div class="col-lg-12">
  </div>
  <!-- /.col-lg-12 -->
</div>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <div class="dataTable-wrapper">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="3" bgcolor="#CCCCCC"><strong>PERIODE PENJUALAN </strong></td>
        </tr>
        <tr>
          <td width="90"><strong>Periode </strong></td>
          <td width="5"><strong>:</strong></td>
          <td width="351"><input name="txtTglAwal" type="text" class="tcal col-sm-2 form-control" value="<?php echo $tglAwal; ?>" />
            sampai dengan
            <input name="txtTglAkhir" type="text" class="tcal col-sm-2 form-control" value="<?php echo $tglAkhir; ?>" />
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input class="btn btn-white" name="btnTampil" type="submit" value=" Tampilkan " /></td>
        </tr>
      </table>
    </div>
  </div>
</form>

<div class="dataTable-wrapper">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="1" cellpadding="3">
      <tr>
        <td width="31" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="88" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
        <td width="126" bgcolor="#CCCCCC"><strong>No. Penjualan </strong></td>
        <td width="180" bgcolor="#CCCCCC"><strong>Pelanggan </strong></td>
        <td width="304" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
        <td width="304" bgcolor="#CCCCCC"><strong>Pembayaran </strong></td><?php /*
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td> */ ?>
      </tr>
      <?php
      //TODO:  Perintah untuk menampilkan Penjualan dengan Filter Periode
      $mySql = "SELECT * FROM penjualan $filterPeriode ORDER BY no_penjualan DESC LIMIT $hal, $row";
      $myQry = $koneksidb->query($mySql);
      $nomor = $hal;
      while ($myData = $myQry->fetch_assoc()) {
        $nomor++;
      ?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><b><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></b></td>
          <td><b><?php echo $myData['no_penjualan']; ?></b></td>
          <td><?php echo $myData['pelanggan']; ?></td>
          <td><?php echo $myData['no_telepon']; ?></td>
          <td><?php echo $myData['bayar']; ?></td> <?php /*
    <td align="center"><a href="cetak/penjualan_cetak.php?noNota=<?php echo $myData['no_penjualan']; ?>" target="_blank">Cetak</a></td> */ ?>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="3"><strong>Jumlah Data :</strong> <label class='btn btn-white'><?php echo $jml; ?></label></td>
        <td colspan="3" align="right"><strong>Halaman ke :</strong>
          <?php
          for ($h = 1; $h <= $max; $h++) {
            $list[$h] = $row * $h - $row;
            echo " <a class='btn btn-white' href='?page=Laporan-Penjualan-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
          }
          ?>
        </td>
      </tr>
    </table>
  </div>
</div>