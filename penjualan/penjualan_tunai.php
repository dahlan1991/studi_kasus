<?php error_reporting(1);
?>
<div class="row">
	<div class="col-lg-7">
		<div class="panel panel-inverse">
			<div class="panel-body">
				<?php
				if (empty($_SESSION['SES_LOGIN'])) {
					//TODO: Refresh
					echo "<meta http-equiv='refresh' content='3; url=../login.php'>";
					echo "<center>";
					echo "<br> <br> <b>Maaf Akses Anda Ditolak!</b> <br>
							Silahkan masukkan Data Login Anda dengan benar untuk bisa mengakses halaman ini.";
					echo "</center>";
					exit;
				}
				//TODO: HAPUS DAFTAR OBAT DI TMP
				if (isset($_GET['Aksi'])) {
					if (trim($_GET['Aksi']) == "Delete") {
						//TODO: Hapus Tmp jika datanya sudah dipindah
						$mySql = "DELETE FROM tmp_penjualan WHERE id='" . $_GET['id'] . "' AND kd_petugas='" . $_SESSION['SES_LOGIN'] . "'";
						$koneksidb->query($mySql);
					}
					if (trim($_GET['Aksi']) == "Sucsses") {
						echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
					}
				}
				//TODO: TOMBOL TAMBAH (INPUT OBAT) DIKLIK
				if (isset($_POST['btnTambah'])) {
					$pesanError = array();
					if (trim($_POST['txtKodeObat']) == "") {
						$pesanError[] = "Data <b>Kode Obat belum diisi</b>, ketik Kode dari Keyboard atau dari <b>Barcode Reader</b> !";
					}
					if (trim($_POST['txtJumlah']) == "" or !is_numeric(trim($_POST['txtJumlah']))) {
						$pesanError[] = "Data <b>Jumlah Obat (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";
					}

					//TODO: Baca variabel
					$txtKodeObat	= $_POST['txtKodeObat'];
					$txtKodeObat	= str_replace("'", "&acute;", $txtKodeObat);
					$txtJumlah	= $_POST['txtJumlah'];

					//TODO: Skrip validasi Stok Obat
					//TODO: Jika stok < (kurang) dari Jumlah yang dibeli, maka buat Pesan Error
					$cekSql	= "SELECT stok FROM obat WHERE kd_obat='$txtKodeObat'";
					$cekQry = $koneksidb->query($cekSql);
					$cekRow = $cekQry->fetch_assoc();
					if ($cekRow['stok'] < $txtJumlah) {
						$pesanError[] = "Stok Obat untuk Kode <b>$txtKodeObat</b> adalah <b> $cekRow[stok]</b>, tidak dapat dijual!";
					}

					//TODO: JIKA ADA PESAN ERROR DARI VALIDASI
					if (count($pesanError) >= 1) {
						echo "<div class='mssgBox'>";
						echo "<img src='../images/attention.png'> <br><hr>";
						$noPesan = 0;
						foreach ($pesanError as $indeks => $pesan_tampil) {
							$noPesan++;
							echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
						}
						echo "</div> <br>";
					} else {
						//TODO: SIMPAN KE DATABASE (tmp_penjualan)	
						//TODO: Periksa, apakah Kode obat atau Kode Barcode yang diinput ada di dalam tabel obat
						$mySql = "SELECT * FROM obat WHERE kd_obat='$txtKodeObat'";
						$myQry = $koneksidb->query($mySql);
						$myRow = $myQry->fetch_assoc();
						if ($myQry->num_rows >= 1) {
							//TODO: Membaca kode obat/ obat
							$kodeObat	= $myRow['kd_obat'];
							//TODO: Jika Kode ditemukan, masukkan data ke Keranjang (TMP)
							$tmpSql 	= "INSERT INTO tmp_penjualan (kd_obat, jumlah,  kd_petugas) 
								VALUES ('$kodeObat', '$txtJumlah',  '" . $_SESSION['SES_LOGIN'] . "')";
							$koneksidb->query($tmpSql);
						}
					}
				}
				//TODO: ========================================================================================================

				//TODO: JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
				if (isset($_POST['btnSimpan'])) {
					$pesanError = array();
					if (trim($_POST['txtTanggal']) == "") {
						$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada kalender !";
					}

					//TODO: Periksa apakah sudah ada obat yang dimasukkan
					$tmpSql = "SELECT COUNT(*) As qty FROM tmp_penjualan WHERE kd_petugas='" . $_SESSION['SES_LOGIN'] . "'";
					$tmpQry = $koneksidb->query($tmpSql);
					$tmpData = $tmpQry->fetch_assoc();
					if ($tmpData['qty'] < 1) {
						$pesanError[] = "<b>DAFTAR OBAT MASIH KOSONG</b>, belum ada obat yang dimasukan, <b>minimal 1 obat</b>.";
					}
					//TODO: Baca variabel from
					$txtTanggal 	= $_POST['txtTanggal'];
					$txtPelanggan	= $_POST['txtPelanggan'];
					$txtTelepon	= $_POST['txtTelepon'];
					$txtBayar	= $_POST['txtBayar'];
					$txtDiskon	= $_POST['txtDiskon'];
					//TODO: JIKA ADA PESAN ERROR DARI VALIDASI 
					if (count($pesanError) >= 1) {
						echo "<div class='mssgBox'>";
						echo "<img src='../assets/img/attention.png'> <br><hr>";
						$noPesan = 0;
						foreach ($pesanError as $indeks => $pesan_tampil) {
							$noPesan++;
							echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
						}
						echo "</div> <br>";
					} else {
						//TODO: SIMPAN DATA KE DATABASE
						//TODO: Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel penjualan dan penjualan_item
						$noTransaksi = buatKode("penjualan", "$faktur");
						//$txtBayar = "Tunai";
						$mySql	= "INSERT INTO penjualan SET 
										no_penjualan='$noTransaksi', 
										tgl_penjualan='" . InggrisTgl($_POST['txtTanggal']) . "', 
										pelanggan='$txtPelanggan',
										no_telepon='$txtTelepon', 
										bayar='$txtBayar',  
										diskon='$txtDiskon',
										kd_petugas='" . $_SESSION['SES_LOGIN'] . "'";
						$koneksidb->query($mySql) or die(mysqli_error($koneksidb));

						//TODO: SIMPAN DATA TMP KE PENJUALAN_ITEM
						//TODO: Ambil semua data obat yang dipilih, berdasarkan kasir yg login
						$tmpSql = "SELECT obat.*, tmp.jumlah FROM obat, tmp_penjualan As tmp
									WHERE obat.kd_obat = tmp.kd_obat AND tmp.kd_petugas='" . $_SESSION['SES_LOGIN'] . "'";
						$tmpQry = $koneksidb->query($tmpSql);
						while ($tmpData = $tmpQry->fetch_assoc()) {
							//TODO: Baca data dari tabel obat dan jumlah yang dibeli dari TMP
							$dataKode 	= $tmpData['kd_obat'];
							$dataHargaM	= $tmpData['harga_modal'];
							$dataHargaJ	= $tmpData['harga_jual'];
							$dataJumlah	= $tmpData['jumlah'];
							$nm_obat = $tmpData['nm_obat'];
							$txtBayar	= $_POST['txtBayar'];
							//TODO: MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
							$itemSql = "INSERT INTO penjualan_item SET 
													no_penjualan='$noTransaksi',
													tgl_penjualan='" . InggrisTgl($_POST['txtTanggal']) . "', 
													kd_obat='$dataKode', 
													harga_modal='$dataHargaM', 
													harga_jual='$dataHargaJ',
													bayar='$txtBayar',  
													jumlah='$dataJumlah',
													nm_obat='$nm_obat' ";
							$koneksidb->query($itemSql);
							//TODO: Skrip Update stok
							$stokSql = "UPDATE obat SET stok = stok - $dataJumlah WHERE kd_obat='$dataKode'";
							$koneksidb->query($stokSql);
						}

						// //TODO: Kosongkan Tmp jika datanya sudah dipindahkan
						$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_petugas='" . $_SESSION['SES_LOGIN'] . "'";
						$koneksidb->query($hapusSql);
						// Jalankan skrip Nota
						//
						echo "<script>alert('Transaksi Pembelian Tunai Selesai. Silahkan ke halaman lap. Tunai');window.location = '?page=Penjualan-Tunai';</script>";
						// Refresh form
						echo "<meta http-equiv='refresh' content='0; url=index.php'>";
					}
				}

				//TODO: TAMPILKAN DATA KE FORM
				$noTransaksi 	= buatKode("penjualan", "$faktur");
				$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
				$dataPelanggan	= isset($_POST['txtPelanggan']) ? $_POST['txtPelanggan'] : 'Tn. ';
				$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
				$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
				$dataDiskon	= isset($_POST['txtDiskon']) ? $_POST['txtDiskon'] : '0';

				if (isset($_POST['txtBayar']) == 'Tunai') {
					$txtBayar = isset($_POST['txtBayar']) ? $_POST['txtBayar'] : 'Tunai';
				}

				?>
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
					<h1> Penjualan Tunai</h1>
					<table border="0" width="100%" cellpadding="3" cellspacing="1" class="table-list">
						<tr>
							<td><br></td>
						</tr>
						<tr>
							<td bgcolor="#CCCCCC"><strong>DATA PENJUALAN </strong></td>
							<td bgcolor="#CCCCCC">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td width="26%"><strong>No. Penjualan </strong></td>
							<td width="2%"><strong>:</strong></td>
							<td width="72%"><input class="col-sm-4 form-control" style-"color:black;" name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="23" readonly="readonly" />
								<span for="" style="font-size:10px;color:#000;">nomor penjualan sudah otomatis</span>
							</td>
						</tr>
						<tr>
							<td><strong>Tgl. Penjualan </strong></td>
							<td><strong>:</strong></td>
							<td><input class="col-sm-4 form-control" name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" maxlength="23" />
								<span for="" style="font-size:10px;color:#000;">Tanggal penjualan sudah otomatis </span>
							</td>
						</tr>
						<tr>
							<td><strong>Pelanggan</strong></td>
							<td><strong>:</strong></td>
							<td><input class="col-sm-8 form-control" class="col-sm-4 form-control" name="txtPelanggan" value="<?php echo $dataPelanggan; ?>" size="70" maxlength="100" />
								<span for="" style="font-size:10px;color:#000;">Masukan nama lengkap pelanggan</span>
							</td>
						</tr>
						<tr>
							<td><strong>No. Telepon</strong></td>
							<td><strong>:</strong></td>
							<td><input class="col-sm-8 form-control" class="col-sm-4 form-control" name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="70" maxlength="100" placeholder="Masukan no. telepon pembeli" />
								<span for="" style="font-size:10px;color:#000;">Masukan nomor telepon pelanggan</span>
							</td>
						</tr>
						<tr>
							<td><strong>Pembayaran</strong></td>
							<td><strong>:</strong></td>
							<td> <b>TUNAI</b>
								<input type="hidden" class="col-sm-8 form-control" name="txtBayar" value="Tunai">
								<br><label for="" style="font-size:10px">Sudah otomatis memilih Tunai</label>
							</td>
						</tr>
						<tr>
							<td><strong>Diskon</strong></td>
							<td><strong>:</strong></td>
							<td width="70%">
								<input type="text" class=" form-control col-sm-1 " name="txtDiskon" value="<?php echo $dataDiskon; ?>" />
								<span for="" style="font-size:10px;color:#000;">Masukan nilai diskon belanja misal 20 berarti 20%</span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td bgcolor="#CCCCCC"><strong>INPUT BARANG </strong></td>
							<td bgcolor="#CCCCCC">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td><strong>Kode Barang </strong></td>
							<td><strong>:</strong></td>
							<td>
								<?php
								$obat = "SELECT * FROM obat";
								$qryObat = $koneksidb->query($obat);
								?>
								<select class="col-sm-8 select2 form-control" name="txtKodeObat" id="">
									<optgroup label="Barang Yang Tersedia">
										<?php while ($dataObat = $qryObat->fetch_assoc()) { ?>
											<option value="<?php echo $dataObat['kd_obat']; ?>"><?php echo $dataObat['nm_obat']; ?> - Rp.<?php echo $dataObat['harga_jual']; ?> - <b>Stok: <?php echo $dataObat['stok']; ?></b> </option>
										<?php } ?>
									</optgroup>
								</select>
								<!--<input class="col-sm-4 form-control" name="txtKodeObat" size="40" maxlength="20" placeholder="Masukan kode obat disamping. ex: H0001/H0002" />-->
								<br><span for="" style="font-size:10px;color:#000;">pilih barang </span>
						</tr>
						<tr>
							<td><b>Jumlah Pembelian </b></td>
							<td><b>:</b></td>
							<td>
								<table>
									<tr>
										<td><input class="col-sm-11 form-control" class="angkaC" name="txtJumlah" size="10" maxlength="4" value="1" onblur="if (value == '') {value = '1'}" onfocus="if (value == '1') {value =''}" />
											<span for="" style="font-size:10px;color:#000;">Masukan jumlah barang </span>
										</td>
										<td><input class="btn btn-primary" name="btnTambah" type="submit" style="cursor:pointer;" value=" MASUKAN KE KERANJANG " /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br>
					<div class="panel panel-inverse">
						<div class="panel-heading">
							<center>
								<h4 style="font-size:16px" class="panel-title">DAFTAR KERANJANG </h4>
								<center>
						</div>
						<table class="table table-list table-bordered" width="800" border="0" cellspacing="1" cellpadding="2">
							<tr>
								<td width="29" bgcolor=""><strong>No</strong></td>
								<td width="85" bgcolor=""><strong>Kode</strong></td>
								<td width="432" bgcolor=""><strong>Nama Barang </strong></td>
								<td width="85" align="" bgcolor=""><strong>Harga (Rp) </strong></td>
								<td width="48" align="" bgcolor=""><strong>Jumlah</strong></td>
								<td width="100" align="" bgcolor=""><strong>Sub Total(Rp) </strong></td>
								<td width="22" align="" bgcolor="">&nbsp;</td>
							</tr>
							<?php
							//TODO: Query menampilkan data dalam Grid TMP_Penjualan 
							$tmpSql = "SELECT obat.*, tmp.id, tmp.jumlah FROM obat, tmp_penjualan As tmp
									WHERE obat.kd_obat=tmp.kd_obat AND tmp.kd_petugas='" . $_SESSION['SES_LOGIN'] . "'
									ORDER BY obat.kd_obat ";
							$tmpQry = $koneksidb->query($tmpSql);
							$nomor = 0;
							$hargaDiskon = 0;
							$totalBayar	= 0;
							$jumlahobat	= 0;
							while ($tmpData = $tmpQry->fetch_assoc()) {
								$nomor++;
								$subSotal 	= $tmpData['jumlah'] * $tmpData['harga_jual'];
								$totalBayar	= $totalBayar + $subSotal;
								$jumlahobat	= $jumlahobat + $tmpData['jumlah'];
								$ppn = 10 / 100;
								$diskon = $dataDiskon / 100;
								$hargraDiskon = $totalBayar * $diskon;
								$hitungPPN = $totalBayar * $ppn;
								$grandtotal = $totalBayar - $hargraDiskon + $hitungPPN;
							?>
								<tr>
									<td><?php echo $nomor; ?></td>
									<td><?php echo $tmpData['kd_obat']; ?></b></td>
									<td><?php echo $tmpData['nm_obat']; ?></td>
									<td align="right"><?php echo format_angka($tmpData['harga_jual']); ?></td>
									<td align="right"><?php echo $tmpData['jumlah']; ?></td>
									<td align="right"><?php echo format_angka($subSotal); ?></td>
									<td><a href="?Aksi=Delete&id=<?php echo $tmpData['id']; ?>" target="_self"><i class="fa fa-trash fa-lg"></i></a></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="4" align="right" bgcolor="#F5F5F5"><strong>TOTAL (Rp.) : </strong></td>
								<td align="right" bgcolor="#F5F5F5"><strong><?php echo $jumlahobat; ?></strong></td>
								<td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBayar); ?></strong></td>
								<td bgcolor="#F5F5F5">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="4" align="right" bgcolor="#F5F5F5"><strong>PPN : </strong></td>
								<td bgcolor="#F5F5F5"><input class="form-control" name="txtTotBayar" type="hidden" value="<?php echo $ppn; ?>" /></td>
								<td colspan="2" bgcolor="#F5F5F5"><b>10%</b></td>
							</tr>
							<tr>
								<td colspan="4" align="right" bgcolor="#F5F5F5"><strong>Diskon (%) : </strong></td>
								<td bgcolor="#F5F5F5"><input class="form-control" name="txtTotBayar" type="hidden" value="<?php echo $totalBayar; ?>" /></td>
								<td colspan="2" bgcolor="#F5F5F5"><b><?php echo $dataDiskon; ?>%</b></td>
							</tr>
							<tr>
								<td colspan="4" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL: </strong></td>
								<td bgcolor="#F5F5F5"><input class="form-control" name="txtTotBayar" type="hidden" value="<?php echo $totalBayar; ?>" /></td>
								<td colspan="3" bgcolor="#F5F5F5"><b><?php echo format_angka($grandtotal); ?></b></td>
							</tr>
						</table>
						<div class="panel-footer text-right">
							<input class="btn btn-primary" name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="panel panel-inverse">
			<div class="panel-body">
				<h1>Data Barang</h1>
				<br>
				<table id="data-table-default" class="table table-list">
					<thead>
						<tr>
							<th width="" align="" bgcolor="">No</th>
							<th width="" bgcolor=""><strong>Nama Barang </strong></th>
							<th width="" bgcolor=""><strong>Stok </strong></th>
							<th width="" bgcolor=""><strong>Harga Jual </strong></th>
							<th width="" bgcolor=""><strong>Harga Reseller </strong></th>
						</tr>
					</thead>
					<?php
					$mySql = "SELECT * FROM obat ORDER BY kd_obat ASC ";
					$myQry = $koneksidb->query($mySql);
					$nomor = 0;
					?>
					<tbody>
						<?php while ($myData = $myQry->fetch_assoc()) {
							$nomor++; ?>
							<tr>
								<td align="center"><?php echo $nomor; ?></td>
								<td><?php echo $myData['nm_obat']; ?></td>
								<td align="center"><b style="font-size:16px"><?php echo $myData['stok']; ?></b></td>
								<td align="center">Rp.<?php echo format_angka($myData['harga_jual']); ?></td>
								<td align="center">Rp.<?php echo format_angka($myData['reseller']); ?></td>
							</tr>
						<?php } ?>
					</tbody>


				</table>

			</div>
		</div>
	</div>
</div>