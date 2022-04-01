<?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

//TODO: Tombol Simpan diklik
if (isset($_POST['btnSimpan'])) {
	//TODO:  VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtNama']) == "") {
		$pesanError[] = "Data <b>Nama Petugas</b> tidak boleh kosong !";
	}
	if (trim($_POST['txtTelepon']) == "") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";
	}
	if (trim($_POST['txtUsername']) == "") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";
	}
	if (trim($_POST['txtPassword']) == "") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";
	}
	if (trim($_POST['cmbLevel']) == "KOSONG") {
		$pesanError[] = "Data <b>Level login</b> belum dipilih !";
	}

	//TODO: BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama = $_POST['txtNama'];
	$txtUsername = $_POST['txtUsername'];
	$txtPassword = $_POST['txtPassword'];
	$txtTelepon	= $_POST['txtTelepon'];
	$cmbLevel	= $_POST['cmbLevel'];

	//TODO: VALIDASI USERNAME LOGIN (username), jika sudah ada akan ditolak
	$cekSql = "SELECT * FROM petugas WHERE username='$txtUsername'";
	$cekQry = $koneksidb->query($cekSql);
	if ($cekQry->num_rows >= 1) {
		$pesanError[] = "Username <b> $txtUsername </b> sudah ada, ganti dengan yang lain";
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
		$kodeBaru	= buatKode("petugas", "P");
		$mySql  	= "INSERT INTO petugas (kd_petugas, nm_petugas, no_telepon, username, pass, password, level)
						VALUES ('$kodeBaru', 
								'$txtNama', 
								'$txtTelepon', 
								'$txtUsername',
								'$txtPassword', 
								MD5('$txtPassword'), 
								'$cmbLevel')";
		$myQry = $koneksidb->query($mySql);
		if ($myQry) {
			// ! echo "<meta http-equiv='refresh' content='0; url=?page=Petugas-Data'>";
			echo "<script>alert('Data telah Disimpan');window.location = '?page=Petugas-Data';</script>";
		}
		exit;
	}
} //TODO:  Penutup Tombol Simpan

//TODO:  VARIABEL DATA UNTUK DIBACA FORM
//TODO:  Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode		= buatKode("petugas", "P");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataPassword	= isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
?>

<ol class="breadcrumb pull-right">
	<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
	<li class="breadcrumb-item active">Tambah Petugas</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Tambah Petugas <small>Menambahkan petugas baru</small></h1>


<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
	<table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
		<tr>
		</tr>
		<tr>
			<td width="181"><b>Kode</b></td>
			<td width="5"><b>:</b></td>
			<td width="1000"> <input class="col-sm-2 form-control" name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly" />
				<span for="" style="font-size:10px;color:#000;">Kode untuk petugas sudah otomatis </span>
			</td>
		</tr>
		<tr>
			<td><b>Nama Petugas </b></td>
			<td><b>:</b></td>
			<td><input class="col-sm-5 form-control" name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" />
				<span for="" style="font-size:10px;color:#000;">Masukan nama lengkap petugas </span>
			</td>
		</tr>
		<tr>
			<td><b>No. Telepon </b></td>
			<td><b>:</b></td>
			<td><input class="col-sm-3 form-control" name="txtTelepon" type="text" value="<?php echo $dataTelepon; ?>" size="60" maxlength="20" />
				<span for="" style="font-size:10px;color:#000;">Masukan no. telepon petugas yang dapat bisa di hubungi </span>
			</td>
		</tr>
		<tr>
			<td><b>Username</b></td>
			<td><b>:</b></td>
			<td> <input class="col-sm-3 form-control" name="txtUsername" type="text" value="<?php echo $dataUsername; ?>" size="60" maxlength="20" />
				<span for="" style="font-size:10px;color:#000;">Masukan username petugas yang diinginkan disaat login </span>
			</td>
		</tr>
		<tr>
			<td><b>Password</b></td>
			<td><b>:</b></td>
			<td><input class="col-sm-5 form-control" name="txtPassword" type="password" size="60" maxlength="20" />
				<span for="" style="font-size:10px;color:#000;">Masukan password petugas yang dinginkan disaat login </span>
			</td>
		</tr>
		<tr>
			<td><b>Level</b></td>
			<td><b>:</b></td>
			<td><b>
					<select class="col-sm-5 form-control" name="cmbLevel">
						<option value="KOSONG">Pilih Akses</option>
						<?php
						$pilihan	= array("Apotek", "Admin");
						foreach ($pilihan as $nilai) {
							if ($dataLevel == $nilai) {
								$cek = " selected";
							} else {
								$cek = "";
							}
							echo "<option value='$nilai' $cek>$nilai</option>";
						}
						?>
					</select>
				</b><span for="" style="font-size:10px;color:#000;">Pilih salah satu : <br>
					'apotek' hanya sebagai penjual saja tidak bisa menambah barang baru/mengubah data petugas <br>
					'admin' sebagai petugas yang bisa mengakses seluruh data toko </span></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>
				<input class="btn btn-inverse" type="submit" name="btnSimpan" value=" Simpan " /> &nbsp; <a class="btn btn-white" href="?page=Petugas-Data">Kembali</a>
			</td>
		</tr>
	</table>
</form>