<?php
include_once "library/inc.seslogin.php";

//TODO:  UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 20;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM petugas";
$pageQry = $koneksidb->query($pageSql);
$jml   = $pageQry->num_rows;
$max   = ceil($jml / $row);
?>
<ol class="breadcrumb pull-right">
  <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
  <li class="breadcrumb-item active">Data Petugas</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Data Petugas <small>Data data petugas yang bisa masuk ke web</small></h1>


<div class="row">
  <div class="col-lg-12">
  </div>
  <!-- /.col-lg-12 -->
</div>
<table border="1" class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="1" cellpadding="3">
  <tr>
    <td width="15%"><a href="?page=Petugas-Add" target="_self"><img src="assets/img/tambah_data.jpg"></img></a></td>
    <td width="20%"><i class="fa fa-edit fa-2x"></i> Untuk mengubah akun pengguna</td>
    <td><i class="fa fa-trash fa-2x"></i> Untuk menghapus barang</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
      <div class="dataTable-wrapper">
        <div class="table-responsive">
          <?php if ($_SESSION['level'] == 'Admin') { ?>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="1" cellpadding="3">
              <thead>
                <tr>
                  <th width="24"><b>No</b></th>
                  <th width="231"><b>Nama Petugas </b></th>
                  <th width="145"><b>No. Telepon </b></th>
                  <th width="170"><b>Username</b></th>
                  <th width="170"><b>Password</b></th>
                  <th width="102"><b>Level</b></th>
                  <th colspan="2" align="center" bgcolor="#CCCCCC"><b>Tools</b><b></b></th>
                </tr>
              </thead>

              <?php
              $mySql   = "SELECT * FROM petugas ORDER BY kd_petugas ASC";
              $myQry   = $koneksidb->query($mySql);
              $nomor  = 0;
              while ($myData = $myQry->fetch_assoc()) {
                $nomor++;
                $Kode = $myData['kd_petugas'];
              ?>
                <tbody>
                  <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $myData['nm_petugas']; ?></td>
                    <td><?php echo $myData['no_telepon']; ?></td>
                    <td><?php echo $myData['username']; ?></td>
                    <td><?php echo $myData['pass']; ?></td>
                    <td><?php echo $myData['level']; ?></td>
                    <td width="41" align="center"><a href="?page=Petugas-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><i class="fa fa-edit fa-2x"></i></a></td>
                    <td width="45" align="center"><a href="?page=Petugas-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')"><i class="fa fa-trash fa-2x"></i></a></td>
                  </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
      </div>
    </td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <label class='btn btn-white'><?php echo $jml; ?></label> </td>
    <td align="right"><b>Halaman ke :</b>
      <?php
            for ($h = 1; $h <= $max; $h++) {
              $list[$h] = $row * $h - $row;
              echo " <a class='btn btn-white' href='?page=Petugas-Data&hal=$list[$h]'>$h</a> ";
            }
      ?>
    </td>
  </tr>
</table> <?php } else {
            echo "Hanya Administrator yang dapat mengubah data Petugas";
          } ?>
</div>
</div>