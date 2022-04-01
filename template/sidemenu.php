<li class="nav-header">Navigation</li>
<li <?php if (@$_GET['page'] == '') {
		echo 'class="has-sub active"';
	} ?>>
	<a href="home.php">
		<i class="fa fa-th-large"></i>
		<span>Dashboard</span>
	</a>
</li>
<li <?php if (@$_GET['page'] == 'Barang-Data') {
		echo 'class="has-sub active"';
	} ?>>
	<a href="?page=Barang-Data">
		<i class="fa fa-plus-circle"></i>
		<span>Data Barang</span>
	</a>
</li>
<li class="nav-header">Transaksi</li>
<li class="has-sub ">
	<a href="penjualan/index.php">
		<i class="fa fa-shopping-cart"></i>
		<span>Penjualan Apotek</span>
	</a>
</li>
<li class="nav-header">Pengaturan</li>
<li <?php if (@$_GET['page'] == 'Laporan-Obat') {
		echo 'class="has-sub active"';
	} ?>>
	<a href="?page=Laporan-Obat">
		<i class="fa fa-book"></i>
		<span>Laporan Obat</span>
	</a>
</li>
<li <?php if (@$_GET['page'] == 'Laporan-Penjualan') {
		echo 'class="has-sub active"';
	} ?>>
	<a href="?page=Laporan-Penjualan">
		<i class="fa fa-book"></i>
		<span>Laporan Penjualan</span>
	</a>
</li>
<li <?php if (@$_GET['page'] == 'Laporan-Penjualan-Periode') {
		echo 'class="has-sub active"';
	} ?>>
	<a href="?page=Laporan-Penjualan-Periode">
		<i class="fa fa-book"></i>
		<span>Lap. Penjualan /Periode</span>
	</a>
</li>
<li <?php if (@$_GET['page'] == 'Laporan-Keuntungan-Periode') {
		echo 'class="has-sub active"';
	} ?>>
	<a href="?page=Laporan-Keuntungan-Periode">
		<i class="fa fa-book"></i>
		<span>Lap. Keuntungan /Periode</span>
	</a>
</li>
<?php if ($_SESSION['level'] == 'Admin') { ?>
	<li class="nav-header">Pengaturan</li>
	<li <?php if (@$_GET['page'] == 'Petugas-Data') {
			echo 'class="has-sub active"';
		} ?>>
		<a href="?page=Petugas-Data">
			<i class="fa fa-user"></i>
			<span>Petugas</span>
		</a>
	</li>
	<li <?php if (@$_GET['page'] == 'Toko') {
			echo 'class="has-sub active"';
		} ?>>
		<a href="?page=Toko">
			<i class='fa fa-cog'></i>
			<span>Toko</span>
		</a>
	</li>
<?php } ?>


<!-- begin sidebar minify button -->
<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
<!-- end sidebar minify button -->
