<?php
if (isset($_POST['btnSimpan'])) {
    $nama_toko = $_POST['nama_toko'];
    $alamat_toko = $_POST['alamat_toko'];
    $no_telepon = $_POST['no_telepon'];
    $no_telepon_2 = $_POST['no_telepon_2'];
    $kode_faktur = $_POST['kode_faktur'];
    $nama_cv = $_POST['nama_cv'];
    # SIMPAN DATA KE DATABASE (Jika tidak menemukan error, simpan data ke database)
    $mySql  = "UPDATE toko SET
            nm_toko='$nama_toko',
            nama_cv='$nama_cv',
            alamat_toko='$alamat_toko',
            no_telepon='$no_telepon',
            no_telepon_2='$no_telepon_2',
            kode_faktur='$kode_faktur' WHERE id=1";
    $myQry = $koneksidb->query($mySql);
    if ($myQry) {
        //echo "<meta http-equiv='refresh' content='0; url=?page=Toko'>";
        echo "<script>alert('Data telah Disimpan');window.location = '?page=Toko';</script>";
    }
    exit;
}
?>
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Pengaturan</a></li>
    <li class="breadcrumb-item active">Toko</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Toko <small>Halaman pengaturan toko...</small></h1>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-lg-6">
        <!-- begin nav-tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-items">
                <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                    <span class="d-sm-none">Tab 1</span>
                    <span class="d-sm-block d-none">Pengaturan Toko</span>
                </a>
            </li>
        </ul>
        <!-- end nav-tabs -->
        <!-- begin tab-content -->
        <div class="tab-content">
            <!-- begin tab-pane --><?php if ($_SESSION['level'] == 'Admin') { ?>
                <div class="tab-pane fade active show" id="default-tab-1">
                    <form action="?page=Toko" method="post" name="form1" target="_self">
                        <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
                            <tr>
                            </tr>
                            <tr>
                                <td width="181"><b>Nama CV</b></td>
                                <td width="5"><b>:</b></td>
                                <td width="1000"> <input class="col-sm-12 form-control" name="nama_cv" type="text" value="<?php echo $ambil['nama_cv']; ?>" size="10" maxlength="255" />
                                    <span for="" style="font-size:10px;color:#000;">Masukan nama CV</span>
                                </td>
                            </tr>
                            <tr>
                                <td width="181"><b>Nama Toko</b></td>
                                <td width="5"><b>:</b></td>
                                <td width="1000"> <input class="col-sm-12 form-control" name="nama_toko" type="text" value="<?php echo $ambil['nm_toko']; ?>" size="10" maxlength="255" />
                                    <span for="" style="font-size:10px;color:#000;">Masukan nama toko</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Alamat </b></td>
                                <td><b>:</b></td>
                                <td><input class="col-sm-12 form-control" name="alamat_toko" type="text" value="<?php echo $ambil['alamat_toko']; ?>" size="80" maxlength="255" />
                                    <span for="" style="font-size:10px;color:#000;">Masukan alamat toko dengan lengkap</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>No. Telepon 1</b></td>
                                <td><b>:</b></td>
                                <td><input class="col-sm-12 form-control" name="no_telepon" type="text" value="<?php echo $ambil['no_telepon']; ?>" size="60" maxlength="20" />
                                    <span for="" style="font-size:10px;color:#000;">Masukan no. telepon toko pertama</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>No. Telepon 2</b></td>
                                <td><b>:</b></td>
                                <td><input class="col-sm-12 form-control" name="no_telepon_2" type="text" value="<?php echo $ambil['no_telepon_2']; ?>" size="60" maxlength="20" />
                                    <span for="" style="font-size:10px;color:#000;">Masukan no. telepon toko kedua</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Kode Barang/Faktur</b></td>
                                <td><b>:</b></td>
                                <td> <input class="col-sm-12 form-control" name="kode_faktur" type="text" value="<?php echo $ambil['kode_faktur']; ?>" size="60" maxlength="3" />
                                    <span for="" style="font-size:10px;color:#000;">Masukan kode untuk barang atau faktur, Max. 3 huruf</span>
                                </td>
                            </tr>
                        </table>
                        <p class="text-right m-b-0">
                            <input class="btn btn-inverse" type="submit" name="btnSimpan" value=" Simpan " /> &nbsp; <a class="btn btn-white" href="?page=Toko">Kembali</a>
                        </p>
                    </form>
                </div>
                <!-- end tab-pane -->
            <?php } else {
                                        echo "<h3>Hanya administrator yang dapat mengubah data toko</h3>";
                                    } ?>
        </div>
        <!-- end tab-content -->
    </div>
    <!-- end col-6 -->
</div>
<!-- end row -->