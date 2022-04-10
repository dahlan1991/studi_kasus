<div class="col-lg-12">
	<div class="panel panel-inverse">
		<div class="panel-body">
			<?php
			//include_once "../library/inc.seslogin.php";
			if (empty($_SESSION['SES_LOGIN'])) {
				// Refresh
				echo "<meta http-equiv='refresh' content='3; url=../login.php'>";

				echo "<center>";
				echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br>
						Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
				echo "</center>";
				exit;
			}

			?>
			<h1 align="center">Pencarian Barang <br> <span style="font-size:14px;">Pencarian nama barang di urut kan berdasarkan nama barang dari A - Z</span> </h1>
			<table id="data-table-default" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th width="4%"><strong>No</strong></th>
						<th width=""><strong>Nama Barang</strong></th>
						<th width="7%" align="right"><strong>Stok</strong></th>
						<th width="15%" align="right"><strong>Harga Modal</strong></th>
						<th width="15%" align="right"><strong>Harga Jual</strong></th>
						<th width="15%" align="right"><strong>Harga Reseller</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$mySql = "SELECT * FROM obat ORDER BY nm_obat ASC";
					$myQry = $koneksidb->query($mySql);
					$nomor  = 0;

					while ($myData = $myQry->fetch_assoc()) {
						$nomor++;
						$Kode = $myData['kd_obat'];
					?>
						<tr>
							<td><?php echo $nomor; ?></td>
							<td><?php echo $myData['nm_obat']; ?></td>
							<td align="center"><b style="font-size:18px"><?php echo $myData['stok']; ?></b></td>
							<td align="left">Rp. <b style="font-size:14px"><?php echo format_angka($myData['harga_modal']); ?></b></td>
							<td align="left">Rp. <b style="font-size:14px"><?php echo format_angka($myData['harga_jual']); ?></b></td>
							<td align="left">Rp. <b style="font-size:14px"><?php echo format_angka($myData['reseller']); ?></b></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
</div>