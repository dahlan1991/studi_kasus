<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
?>
<ol class="breadcrumb pull-right">
  <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
  <li class="breadcrumb-item active">Data Barang</li>
</ol>
<h1 class="page-header">Data Barang <small>Halaman Utama Untuk Data Data barang yang dijual ...</small></h1>

<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="1" cellpadding="3">
  <tr>
    <?php if ($_SESSION['level'] == 'Admin') { ?>
      <td width="" colspan="2"><a href="?page=Barang-Add" target="_self"><img src="assets/img/tambah_data.jpg"></img></td>
    <?php } ?>
    <td><i class="fa fa-edit fa-2x"></i> Untuk mengubah data, baik menambah/mengurangi stok barang</td>
    <td><i class="fa fa-trash fa-2x"></i> Untuk menghapus barang</td>
  </tr>
</table>

<div class="panel panel-inverse">
  <div class="panel-body">
    <table id="data-table-default" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th width=""><strong>No</strong></th>
          <th width=""><strong>Kode</strong></th>
          <th width=""><strong>Nama Barang</strong></th>
          <th width="" align="center"><strong>Stok <br>(Tersedia)</strong></th>
          <th width="" align="right"><strong>Harga <br> Modal</strong></th>
          <th width="" align="right"><strong>Harga <br> Jual</strong></th>
          <th width="" align="right"><strong>Harga <br> Reseller</strong></th>
          <th><strong>Total <br> Harga</strong></th>
          <?php if ($_SESSION['level'] == 'Admin') { ?>
            <th align="center" bgcolor="#CCCCCC"><strong>Tools</strong></th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $mySql = "SELECT * FROM obat ORDER BY kd_obat DESC";
        $myQry = $koneksidb->query($mySql);
        $nomor  = 0;

        while ($myData = $myQry->fetch_assoc()) {
          $nomor++;
          $Kode = $myData['kd_obat'];

          $harga_jual = $myData['harga_jual'];
          $stok = $myData['stok'];
          $jumlah = $stok * $harga_jual;
        ?>
          <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $myData['kd_obat']; ?></td>
            <td><?php echo $myData['nm_obat']; ?></td>
            <td align="center"><b style="font-size:16px"><?php echo $myData['stok']; ?></b></td>
            <td align="left">Rp. <?php echo format_angka($myData['harga_modal']); ?></td>
            <td align="left">Rp. <?php echo format_angka($myData['harga_jual']); ?></td>
            <td align="left">Rp. <?php echo format_angka($myData['reseller']); ?></td>
            <td align="left">Rp. <?php echo format_angka($jumlah); ?></td>
            <?php if ($_SESSION['level'] == 'Admin') { ?>
              <td width="" align="center">
                <a href="?page=Barang-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><i class="fa fa-edit "></i></a> |
                <a href="?page=Barang-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA OBAT INI ... ?')"><i class="fa fa-trash" style="color: red;"></i></a>
              </td>
            <?php } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>