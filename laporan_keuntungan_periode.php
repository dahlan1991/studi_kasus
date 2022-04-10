<?php
include_once "library/inc.seslogin.php";

//TODO:  Deklarasi variabel
$filterPeriode = "";
$tglAwal  = "";
$tglAkhir  = "";

//TODO:  Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal   = isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-" . date('m-Y');
$tglAkhir   = isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

//TODO:  Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
  //TODO:  Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterPeriode = "WHERE ( tgl_penjualan BETWEEN '" . InggrisTgl($tglAwal) . "' AND '" . InggrisTgl($tglAkhir) . "') AND bayar ='Tunai' ";
} else {
  //TODO:  Membaca data tanggal dari URL, saat Nomor Halaman diklik
  $tglAwal   = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir;

  //TODO:  Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterPeriode = "WHERE ( tgl_penjualan BETWEEN '" . InggrisTgl($tglAwal) . "' AND '" . InggrisTgl($tglAkhir) . "') AND bayar ='Tunai'  ";
}

//TODO: UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan_item $filterPeriode";
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
<h1 class="page-header">Laporan Keuntungan Penjualan <small>Laporan keuntungan penjualan berdasarkan periode tanggal</small></h1>
<div class="row">
  <div class="col-lg-12">
    <div class="alert alert-info" role="alert">
      Untuk PPH21 UMUM :
      <ol>
        <li>jika Penjualannya lebih dari 500 juta dalam 1 tahun maka PPH nya adalah 0.5% dan akan secara otomatis di hitung.</li>
        <li>jika Penjualannya kecil dari 500juta maka PPH nya adalah 0% (nol persen).</li>
      </ol>
    </div>
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
        <td width="180" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
        <td width="108" bgcolor="#CCCCCC"><strong>Harga Modal </strong></td>
        <td width="180" bgcolor="#CCCCCC"><strong>Harga Jual </strong></td>
        <td width="31" bgcolor="#CCCCCC"><strong>Jumlah </strong></td>
        <td width="180" bgcolor="#CCCCCC"><strong>Subtotal </strong></td>

      </tr>
      <?php
      //TODO:  Perintah untuk menampilkan Penjualan dengan Filter Periode
      $mySql = "SELECT * FROM penjualan_item $filterPeriode  ORDER BY no_penjualan DESC LIMIT $hal, $row";
      $myQry = $koneksidb->query($mySql);
      $nomor = $hal;
      while ($myData = $myQry->fetch_assoc()) {
        $nomor++;
        $jual = $myData['harga_jual'];
        $jumlah = $myData['jumlah'];
        $subTotal = $jual * $jumlah;
      ?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><b><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></b></td>
          <td><b><?php echo $myData['no_penjualan']; ?></b></td>
          <td><?php echo $myData['nm_obat']; ?></td>
          <td>Rp. <?php echo number_format($myData['harga_modal'], 0, ',', '.'); ?></td>
          <td>Rp. <?php echo number_format($myData['harga_jual'], 0, ',', '.'); ?></td>
          <td><?php echo $myData['jumlah']; ?> Pcs </td>
          <td>Rp. <?php echo number_format($subTotal, 0, ',', '.'); ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="6" align="right"><strong>Total </strong></td>
        <?php
        $qryTotObat = $koneksidb->query("SELECT SUM(jumlah) FROM penjualan_item $filterPeriode ORDER BY no_penjualan DESC LIMIT $hal, $row");
        $resTotObat = $qryTotObat->fetch_array();
        $jum_res_totObat = $resTotObat[0];
        ?>
        <td><b><?php echo $resTotObat[0]; ?> Pcs</b></td>
        <?php
        $qryTot = $koneksidb->query("SELECT SUM(harga_jual) FROM penjualan_item $filterPeriode ORDER BY no_penjualan DESC LIMIT $hal, $row");
        $resTot = $qryTot->fetch_array();
        $jum_res_tot = $resTot[0];
        ?>
        <td><b style="font-size:16px;">Rp. <?php echo number_format($resTot[0], 0, ',', '.'); ?></b></td>
      </tr>
      <tr>
        <td colspan="2" align="right" style="font-size:15px;padding-top: 20px;"><strong>Keuntungan </strong></td>
        <?php
        $qryTot = $koneksidb->query("SELECT SUM(harga_jual) as jual FROM penjualan_item $filterPeriode ORDER BY no_penjualan DESC LIMIT $hal, $row");
        $resTot = $qryTot->fetch_array();
        $jum_res_tot = $resTot[0];

        $qryTotModal = $koneksidb->query("SELECT SUM(harga_modal) as harga_modal FROM penjualan_item $filterPeriode ORDER BY no_penjualan DESC LIMIT $hal, $row");
        $resTotModal = $qryTotModal->fetch_array();
        $jum_res_totModal = $resTotModal[0];
        //* memasukan PPH21 0.5% 
        $PPH = 0.5 / 100;
        //* menhitung PPH dari total penjualan. 0.5% nya dari toal penjualan.
        $hitungPPH = $jum_res_tot * $PPH;
        // $keuntungan = $jum_res_tot - $jum_res_totModal;
        ?>
        <td colspan="4" align="right" style="font-size:15px;padding-top: 20px;">
          <b>Rp. <?php echo number_format($resTot['jual'], 0, ',', '.'); ?></b> (TOTAL) - <b>Rp. <?php echo number_format($resTotModal['harga_modal'], 0, ',', '.'); ?></b>(Harga Modal)
          <?php if ($jum_res_tot > 500000000) {
            echo "- PPH21 <b>(Rp. " . number_format($hitungPPH, 0, ',', '.') . ")</b>";
          } ?> =
        </td>
        <td colspan="2">
          <b style="font-size:32px">
            <?php
            //TODO mengitung PPH21 jika penjualan kecil dari 500juta, maka PPH nya adalah 0% (nol persen)
            if ($jum_res_tot < 500000000) {
              //* karena PPH21 nya adalah 0% (nol persen) maka tidak mengihtung PPH21 nya. melainkan langsung keuntungan nya.
              $keuntungan = $jum_res_tot - $jum_res_totModal;
              echo "Rp. " . number_format($keuntungan, 0, ',', '.');
            } else {
              //TODO JIKA PPH 21 NYA LEBIH DARI 500 JUTA MAKA PPH 2! NYA ADALAH 0.5%
              //*menhitung keselurhan keuntungan setelah dikurangi PPH21 sebnyak 0.5%.
              $keuntungan = $jum_res_tot - $jum_res_totModal - $hitungPPH;
              echo "Rp. " . number_format($keuntungan, 0, ',', '.');
            }
            ?>
          </b>
        </td>
      </tr>
      <tr>
        <td colspan="8">Terbilang : &nbsp; &nbsp;&nbsp; <label style="font-size:20px;color:#000;"><b><i><?php echo strtoupper(terbilang($keuntungan)); ?> RUPIAH</i></b></label></td>
      </tr>
      <tr>
        <td colspan="5"><strong>Jumlah Data :</strong> <label class='btn btn-white'><?php echo $jml; ?></label></td>
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