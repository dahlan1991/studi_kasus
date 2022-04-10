<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
include_once "../library/inc.terbilang.php";

date_default_timezone_set("Asia/Jakarta");
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<title>Penjualan | <?php echo $ambil['nm_toko']; ?></title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<link rel="shortcut icon" href="../assets/img/logo.png" type="image/x-icon" />

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="../assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
	<link href="../assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
	<link href="../assets/plugins/animate/animate.min.css" rel="stylesheet" />
	<link href="../assets/css/default/style.min.css" rel="stylesheet" />
	<link href="../assets/css/default/style-responsive.min.css" rel="stylesheet" />
	<link href="../assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
	<link href="../assets/plugins/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="../assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="../assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" />
	<link href="../assets/plugins/select2/select2.min.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="../assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>

<body>
	<!-- begin #page-loader -->
	<!-- <div id="page-loader" class="fade show"><span class="spinner"></span></div> -->
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="page-container  page-without-sidebar page-header-fixed page-with-top-menu">
		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				<a href="index.php" class="navbar-brand"><i class="fas fa-shopping-cart fa-lg"></i> <b><?php echo $ambil['nm_toko'] ?></b></a>

			</div>
			<!-- end navbar-header -->

			<!-- begin header navigation right -->
			<ul class="navbar-nav navbar-right">

				<li class="dropdown navbar-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						Selamat datang kembali,
						<span class="d-none d-md-inline">" <?php echo $_SESSION['petugas']; ?> "</span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="../logout.php" class="dropdown-item">Log Out</a>
					</div>
				</li>
			</ul>
			<!-- end header navigation right -->
		</div>
		<!-- end #header -->
		<!-- begin #top-menu -->
		<div id="top-menu" class="top-menu">
			<!-- begin top-menu nav -->
			<ul class="nav">
				<li <?php if (@$_GET['page'] == '') {
						echo 'class="has-sub "';
					} ?>>
					<a href="../home.php">
						<i class="fa fa-th-large"></i>
						<span>Home</span>
					</a>
				</li>
				<li <?php if (@$_GET['page'] == 'Penjualan-Tunai') {
						echo 'class="has-sub active"';
					} ?>>
					<a href="?page=Penjualan-Tunai">
						<i class="fa fa-shopping-cart"></i>
						<span>Penjualan Tunai</span>
					</a>
				</li>
				<li <?php if (@$_GET['page'] == 'Penjualan-Tampil') {
						echo 'class="has-sub active"';
					} ?>>
					<a href="?page=Penjualan-Tampil">
						<i class="fa fa-book"></i>
						<span>Lap. Penjualan Tunai</span>
					</a>
				</li>

				<li <?php if (@$_GET['page'] == 'Pencarian-Barang') {
						echo 'class="has-sub active"';
					} ?>>
					<a href="?page=Pencarian-Barang">
						<i class="fa fa-search"></i>
						<span>Pencarian</span>
					</a>
				</li>
				<li class="menu-control menu-control-left">
					<a href="javascript:;" data-click="prev-menu"><i class="fa fa-angle-left"></i></a>
				</li>
				<li class="menu-control menu-control-right">
					<a href="javascript:;" data-click="next-menu"><i class="fa fa-angle-right"></i></a>
				</li>
			</ul>
			<!-- end top-menu nav -->
		</div>
		<!-- end #top-menu -->

		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin panel -->
			<?php
			# KONTROL MENU PROGRAM
			if (isset($_GET['page'])) {
				$page = $_GET['page'];

				switch ($page) {
					case 'Penjualan-Tunai';
						include_once "penjualan_tunai.php";
						break;

					case 'Penjualan-Kredit';
						include_once "penjualan_kredit.php";
						break;


					case 'Penjualan-Tampil';
						include_once "penjualan_tampil.php";
						break;

					case 'Penjualan-Tampil-Kredit';
						include_once "penjualan_tampil_kredit.php";
						break;

					case 'Pencarian-Barang';
						include_once "pencarian_barang.php";
						break;

					case 'Penjualan-Hapus';
						include_once "penjualan_hapus.php";
						break;

					default;
						"<center><h3 style='color:white;'>Maaf. Halaman tidak di temukan !</h3></center>";
						break;
				}
			} else {
				include_once 'penjualan_tunai.php';
			}
			?>

		</div>
		<!-- end #content -->

		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="../assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="../assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<!--[if lt IE 9]>
		<script src="../assets/crossbrowserjs/html5shiv.js"></script>
		<script src="../assets/crossbrowserjs/respond.min.js"></script>
		<script src="../assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../assets/plugins/js-cookie/js.cookie.js"></script>
	<script src="../assets/js/theme/default.min.js"></script>
	<script src="../assets/js/apps.min.js"></script>
	<!-- ================== END BASE JS ================== -->

	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="../assets/plugins/datatables/jquery.dataTables.js"></script>
	<script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="../assets/plugins/datatables/dataTables.responsive.min.js"></script>
	<script src="../assets/js/table-manage-default.min.js"></script>
	<script src="../assets/plugins/select2/select2.min.js"></script>
	<script src="../assets/js/form-plugins.min.js"></script>

	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			TableManageDefault.init();
			FormPlugins.init();
		});
	</script>
	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});
	</script>

</body>

</html>