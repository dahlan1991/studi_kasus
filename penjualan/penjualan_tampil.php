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
			<h1 align="center">Laporan Penjualan Tunai <br>
				<span style="font-size:14px;">Pencarian Faktur penjualan di urut kan berdasarkan nomor Faktur terbaru</span>
			</h1>
			<h5 align="center">
				' <i class="fa fa-print fa-2x"></i> Faktur Tunai &nbsp;&nbsp;
				' <i class="fa fa-trash fa-2x"></i> ' Untuk menghapus laporan
			</h5>

			<table id="data-table-default" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th width="1%">#</th>
						<th class="text-nowrap">No. Faktur</th>
						<th class="text-nowrap">Tgl. Faktur</th>
						<th class="text-nowrap">Pelanggan</th>
						<th class="text-nowrap">No. Telepon</th>
						<th class="text-nowrap">Diskon</th>
						<th class="text-nowrap">Petugas</th>
						<th class="text-nowrap">Tools</th>

					</tr>

				</thead>
				<tbody>
					<?php
					$mySql = "SELECT penjualan.*, petugas.nm_petugas
                    FROM penjualan 
                    LEFT JOIN petugas ON penjualan.kd_petugas = petugas.kd_petugas WHERE bayar = 'Tunai'
                    ORDER BY penjualan.no_penjualan DESC ";
					$myQry = $koneksidb->query($mySql);
					$nomor = 0;
					while ($myData = $myQry->fetch_assoc()) {
						$nomor++;
						$Kode = $myData['no_penjualan'];
					?>

						<tr class="even gradeC">
							<td class="f-s-600 text-inverse"><?php echo $nomor; ?></td>
							<td><b><?php echo $myData['no_penjualan']; ?></b></td>
							<td><b><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></b></td>
							<td><?php echo $myData['pelanggan']; ?></td>
							<td><?php echo $myData['no_telepon']; ?></td>
							<td><b style="font-size:15px;"><?php echo $myData['diskon']; ?>%</b></td>
							<td><?php echo $myData['nm_petugas']; ?></td>
							<td>
								<a href="penjualan_faktur.php?noFaktur=<?php echo $Kode; ?>" target="_blank" title="FAKTUR"><i class="fa fa-print fa-2x"></i></a>
								<?php if ($_SESSION['level'] == 'Admin') { ?> | <a href="?page=Penjualan-Hapus&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENJUALAN INI ... ?')" title="HAPUS"><i class="fa fa-trash fa-2x"></i></a> <?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>