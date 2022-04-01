<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

// TODO: Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if (isset($_GET['Kode'])) {
	// TODO: Hapus data sesuai Kode yang didapat di URL
	$mySql = "DELETE FROM obat WHERE kd_obat='" . $_GET['Kode'] . "'";
	$myQry = $koneksidb->query($mySql);
	if ($myQry) {
		// TODO: Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?page=Barang-Data'>";
	}
} else {
	// TODO: Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
