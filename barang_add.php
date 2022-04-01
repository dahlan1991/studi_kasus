<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";


//TODO: Membaca tombol Simpan saat diklik
if (isset($_POST['btnSimpan'])) {
	//TODO: Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($_POST['txtNama']) == "") {
		$pesanError[] = "Data <b>Nama Obat</b> tidak boleh kosong !";
	}
	if (trim($_POST['txtHargaModal']) == "" or !is_numeric(trim($_POST['txtHargaModal']))) {
		$pesanError[] = "Data <b>Harga Modal (Rp.)</b> jual tidak boleh kosong, harus diisi angka!";
	}
	if (trim($_POST['txtHargaJual']) == "" or !is_numeric(trim($_POST['txtHargaJual']))) {
		$pesanError[] = "Data <b>Harga Jual (Rp.)</b> jual tidak boleh kosong, harus diisi angka!";
	}
	if (trim($_POST['txtHargaReseller']) == "" or !is_numeric(trim($_POST['txtHargaReseller']))) {
		$pesanError[] = "Data <b>Harga Reseller (Rp.)</b> jual tidak boleh kosong, harus diisi angka!";
	}
	if (trim($_POST['txtStok']) == "" or !is_numeric(trim($_POST['txtStok']))) {
		$pesanError[] = "Data <b>Stok Obat</b> masih kosong, harus diisi angka !";
	}
	if (trim($_POST['txtKeterangan']) == "") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";
	}

	//TODO: Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtHargaModal	= $_POST['txtHargaModal'];
	$txtHargaJual	= $_POST['txtHargaJual'];
	$txtHargaReseller	= $_POST['txtHargaReseller'];
	$txtStok		= $_POST['txtStok'];
	$txtKeterangan	= $_POST['txtKeterangan'];

	//TODO: Validasi Nama obat, jika sudah ada akan ditolak
	$sqlCek = "SELECT * FROM obat WHERE nm_obat='$txtNama'";
	$qryCek = $koneksidb->query($sqlCek);
	if ($qryCek->num_rows >= 1) {
		$pesanError[] = "Maaf, Nama Obat <b> $txtNama </b> sudah ada dalam database, ganti dengan yang lain";
	}


	//TODO: JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError) >= 1) {
		echo "<div class='mssgBox'>";
		echo "<img src='assets/img/attention.png'> <br><hr>";
		$noPesan = 0;
		foreach ($pesanError as $indeks => $pesan_tampil) {
			$noPesan++;
			echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
		}
		echo "</div> <br>";
	} else {
		//TODO: SIMPAN DATA KE DATABASE. 
		//TODO: Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("obat", "$faktur");
		$mySql	= "INSERT INTO obat (kd_obat, nm_obat, harga_modal, harga_jual, stok, keterangan, reseller) 
						VALUES ('$kodeBaru',
								'$txtNama',
								'$txtHargaModal',
								'$txtHargaJual',
								'$txtStok',
								'$txtKeterangan',
								'$txtHargaReseller')";
		$myQry	= $koneksidb->query($mySql);
		if ($myQry) {
			//! echo "<meta http-equiv='refresh' content='0; url=?page=Obat-Add'>";
			echo "<script>alert('Data telah Disimpan');window.location = '?page=Barang-Data';</script>";
		}
		exit;
	}
} //TODO: Penutup POST


# VARIABEL DATA UNTUK FORM
$dataKode	= buatKode("obat", "$faktur");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataHargaModal	= isset($_POST['txtHargaModal']) ? $_POST['txtHargaModal'] : '0';
$dataHargaJual	= isset($_POST['txtHargaJual']) ? $_POST['txtHargaJual'] : '0';
$dataHargaReseller	= isset($_POST['txtHargaReseller']) ? $_POST['txtHargaReseller'] : '0';
$dataStok		= isset($_POST['txtStok']) ? $_POST['txtStok'] : '0';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<ol class="breadcrumb pull-right">
	<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
	<li class="breadcrumb-item active">Tambah Barang</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Tambah Barang <small>Menambahkan Barang baru</small></h1>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<th colspan="3" scope="col"></th>
		</tr>
		<tr>
			<td width="16%"><strong>Kode</strong></td>
			<td width="1%"><strong>:</strong></td>
			<td width="83%"><input class=" col-sm-2 form-control" name="textfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly" />
				<span for="" style="font-size:10px;color:#000;">Kode barang sudah otomatis</span>
			</td>
		</tr>
		<tr>
			<td><strong>Nama Barang </strong></td>
			<td><strong>:</strong></td>
			<td><input class="col-sm-5 form-control" name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
				<span for="" style="font-size:10px;color:#000;">Masukan nama barang dengan lengkap</span>
			</td>
		</tr>
		<tr>
			<td><strong>Harga Modal (Rp.) </strong></td>
			<td><strong>:</strong></td>
			<td><input class="col-sm-2  form-control" name="txtHargaModal" value="<?php echo $dataHargaModal; ?>" size="20" maxlength="12" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}" /><span for="" style="font-size:10px;color:#000;">Masukan harga modal barang</span></td>
		</tr>
		<tr>
			<td><strong>Harga Jual (Rp.) </strong></td>
			<td><strong>:</strong></td>
			<td><input class="col-sm-2 form-control" name="txtHargaJual" value="<?php echo $dataHargaJual; ?>" size="20" maxlength="12" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}" /><span for="" style="font-size:10px;color:#000;">Masukan harga jual branag</span></td>
		</tr>
		<tr>
			<td><strong>Harga Reseller (Rp.) </strong></td>
			<td><strong>:</strong></td>
			<td><input class="col-sm-2 form-control" name="txtHargaReseller" value="<?php echo $dataHargaReseller; ?>" size="20" maxlength="12" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}" /><span for="" style="font-size:10px;color:#000;">Masukan harga untuk reseller</span></td>
		</tr>
		<tr>
			<td><strong>Stok</strong></td>
			<td><strong>:</strong></td>
			<td><input class="col-sm-1 form-control" name="txtStok" value="<?php echo $dataStok; ?>" size="14" maxlength="10" />
				<span for="" style="font-size:10px;color:#000;">Masukan jumlah stok barang yang ada</span>
			</td>
		</tr>
		<tr>
			<td><strong>Keterangan</strong></td>
			<td><strong>:</strong></td>
			<td><input class="col-sm-5 form-control" name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="200" />
				<span for="" style="font-size:10px;color:#000;">Masukan keterangan barang dengan lengkap</span>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input class="btn btn-inverse" type="submit" name="btnSimpan" value=" Simpan " style="cursor:pointer;">&nbsp;<a class="btn btn-white" href="?page=Barang-Data">Kembali</a></td>
		</tr>
	</table>
</form>