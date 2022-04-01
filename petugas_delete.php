<?php
include_once "library/inc.seslogin.php";

//TODO: Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	// Hapus data sesuai Kode yang didapat di URL
	$mySql = "DELETE FROM petugas WHERE kd_petugas='" . $_GET['Kode'] . "' AND username !='admin'";
	$myQry = $koneksidb->query($mySql);
	if ($myQry) {
		//TODO: Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?page=Petugas-Data'>";
	}
} else {
	//TODO: Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
