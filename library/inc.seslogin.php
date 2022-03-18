<?php
if(empty($_SESSION['SES_LOGIN'])) {
	// Refresh
	echo "<meta http-equiv='refresh' content='3; url=login.php'>";
	echo "<link rel='shortcut icon' href='assets/img/logo.png' type='image/x-icon'/>";
	
	echo "<center>";
	echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br> Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
	echo "</center>";
	exit;
}
?>
