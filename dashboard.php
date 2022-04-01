<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
	<li class="breadcrumb-item active">Dashboard</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Dashboard <small>Halaman Utama Toko...</small></h1>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6">
		<div class="widget widget-stats bg-red">
			<div class="stats-icon"><i class="fa fa-plus-circle"></i></div>
			<div class="stats-info">
				<h4>TOTAL BARANG</h4>
				<?php
				$sql_obat = "SELECT * FROM obat";
				$que_obat = $koneksidb->query($sql_obat);
				$res_obat = $que_obat->num_rows;
				?>
				<p><?php echo $res_obat ?></p>
			</div>
			<div class="stats-link">
				<a href="?page=Barang-Data">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6">
		<div class="widget widget-stats bg-grey-darker">
			<div class="stats-icon"><i class="fa fa-book"></i></div>
			<div class="stats-info">
				<h4>STOK SEMUA BARANG</h4>
				<?php
				$sql_lap = "SELECT SUM(stok) as stok FROM obat";
				$que_lap = $koneksidb->query($sql_lap);
				$stok_qry = $que_lap->fetch_assoc();
				$stok = $stok_qry['stok'];
				?>
				<p><?php echo $stok ?></p>
			</div>
			<div class="stats-link">
				<a href="">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6">
		<div class="widget widget-stats bg-orange">
			<div class="stats-icon"><i class="fa fa-shopping-cart"></i></div>
			<div class="stats-info">
				<h4>BARANG TERJUAL</h4>
				<?php
				$sql_terjual = "SELECT * FROM penjualan_item";
				$que_terjual = $koneksidb->query($sql_terjual);
				$res_terjual = $que_terjual->num_rows;
				?>
				<p><?php echo $res_terjual ?></p>
			</div>
			<div class="stats-link">
				<a href="">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6">
		<div class="widget widget-stats bg-grey-darker">
			<div class="stats-icon"><i class="fa fa-book"></i></div>
			<div class="stats-info">
				<h4>LAP. PENJUALAN</h4>
				<?php
				$sql_lap = "SELECT * FROM penjualan";
				$que_lap = $koneksidb->query($sql_lap);
				$res_lap = $que_lap->num_rows;
				?>
				<p><?php echo $res_lap ?></p>
			</div>
			<div class="stats-link">
				<a href="?page=Laporan-Penjualan">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<?php if ($_SESSION['level'] == 'Admin') { ?>
		<div class="col-lg-3 col-md-6">
			<div class="widget widget-stats bg-black-lighter">
				<div class="stats-icon"><i class="fa fa-users"></i></div>
				<div class="stats-info">
					<h4>PETUGAS</h4>
					<?php
					$sql_petugas = "SELECT * FROM petugas";
					$que_petugas = $koneksidb->query($sql_petugas);
					$res_petugas = $que_petugas->num_rows;
					?>
					<p><?php echo $res_petugas ?></p>
				</div>
				<div class="stats-link">
					<a href="?page=Petugas-Data">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- end col-3 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card m-b-30 text-white card-primary">
			<div class="card-body">
				<table class="table table-responsive ">
					<thead>
						<tr>
							<th>Stok Keseluruhan <br>( Total Semua Stok Barang Yang Tersedia )</th>
							<th>Jumlah Harga Barang Keseluruhan Yang Tersedia <br>( Harga Tiap 1 Barang/Jenis )</th>
							<th>Total Keseluruhan Harga <br> (Total Harga Seluruh Barang)</th>
						</tr>
					</thead>
					<?php
					///TOTAL STOK
					$sql_lap = "SELECT SUM(stok) as stok FROM obat";
					$que_lap = $koneksidb->query($sql_lap);
					$stok_qry = $que_lap->fetch_assoc();
					$stok = $stok_qry['stok'];
					///TOTAL HARGA JUAL
					$sql = $koneksidb->query("SELECT SUM(harga_jual) as total FROM obat");
					$res = $sql->fetch_assoc();
					$total = $res['total'];
					///TOTAL HARGA KESELURUHAN
					$sql_total = $koneksidb->query("SELECT SUM(stok * harga_jual) as total FROM obat");
					$res_total = $sql_total->fetch_assoc();
					$total_keseluruhan = $res_total['total'];
					?>
					<tbody>
						<tr>
							<td style="font-size:24px;color:#000;"><b><?php echo $stok ?></b></td>
							<td style="font-size:24px;color:#000;"><b>Rp. <?php echo number_format($total, 0, ',', '.');  ?></b></td>
							<td style="font-size:32px;color:#000;"><b>Rp. <?php echo number_format($total_keseluruhan, 0, ',', '.');  ?></b></td>
						</tr>
						<tr>
							<td colspan="3">Terbilang : &nbsp; &nbsp;&nbsp; <label style="font-size:20px;color:#000;"><b><i><?php echo strtoupper(terbilang($total_keseluruhan)); ?> RUPIAH</i></b></label></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>
<!-- end row -->