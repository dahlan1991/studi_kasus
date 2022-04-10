<?php
//include_once "../library/inc.seslogin.php";

if (empty($_SESSION['SES_LOGIN'])) {
	//TODO:  Refresh
	echo "<meta http-equiv='refresh' content='3; url=../login.php'>";

	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br>
		Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
	echo "</center>";
	exit;
}
//TODO:  Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	$Kode	= $_GET['Kode'];

	//TODO:  Hapus data sesuai Kode yang didapat di URL
	$mySql = "DELETE FROM penjualan WHERE no_penjualan='$Kode'";
	$myQry = $koneksidb->query($mySql);
	if ($myQry) {

		//TODO:  Baca data dalam tabel anak (penjualan_item)
		$bacaSql = "SELECT * FROM penjualan_item WHERE no_penjualan='$Kode'";
		$bacaQry = $koneksidb->query($bacaSql);
		while ($bacaData = $bacaQry->fetch_assoc()) {
			$KodeObat	= $bacaData['kd_obat'];
			$jumlah		= $bacaData['jumlah'];

			//TODO:  Skrip Kembalikan Jumlah Stok
			$stokSql = "UPDATE obat SET stok = stok + $jumlah WHERE kd_obat='$KodeObat'";
			$koneksidb->query($stokSql);
		}

		//TODO:  Hapus data pada tabel anak (penjualan_item)
		$mySql = "DELETE FROM penjualan_item WHERE no_penjualan='$Kode'";
		$koneksidb->query($mySql);

		//TODO: Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?page=Penjualan-Tampil'>";
	}
} else {
	//TODO:  Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
