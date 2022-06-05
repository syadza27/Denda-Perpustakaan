<?php 

// koneksi
$conn = new mysqli('localhost', 'root', '', 'perpus');

if (isset($_POST['submit'])) {
	// untuk disimpan didatabase
	$tgl_pinjam = $_POST['tgl_pinjam'];
	$tgl_kembali = strtotime("+7 day", strtotime($tgl_pinjam)); // +7 hari dari tgl peminjaman
	$tgl_kembali = date('Y-m-d', $tgl_kembali); // format tgl peminjaman tahun-bulan-hari

	$q = $conn->query("INSERT INTO detail_pinjam (tgl_pinjam, tgl_kembali) VALUES ('$tgl_pinjam', '$tgl_kembali')");
	unset($_POST['submit']);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Tutorial PHP</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>

<div class="container mt-4">
	<center>
		<h1>PlajariKode</h1>
		<h3>Menghitung denda terlambat pengembalian buku</h3>
	</center>


	<div class="card mx-auto col-md-8 mt-4">
		<div class="alert alert-info">
			<small>
				* Waktu peminjaman buku hanya 7 hari<br/>
				* Set waktu > 7 hari sebelum tanggal sekarang<br/>
				* Denda keterlambatan 1000/hari<br/>
				* Hanya menampilkan data yg terlambat mengembalikan
			</small>
		</div>
		<div class="card-body mx-auto">
			<form method="post" action="" class="form-inline">
				<label for="tgl_pinjam">Tanggal Pinjam&nbsp;</label>
				<input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control mr-2">
				<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
			</form>

			<table class="table table-bordered mt-4">
				<tr>
					<th>#</th>
					<th>Tgl. Peminjaman</th>
					<th>Tgl. Pengembalian</th>
					<th>Terlambat (Hari)</th>
					<th>Total Denda</th>
				</tr>

				<?php
				// hanya menampilkan data yang terlambat
				$q = $conn->query("SELECT * FROM detail_pinjam WHERE CURDATE() > tgl_kembali");
		
				$no = 1;
				while($r = $q->fetch_assoc()) {
					// untuk menghitung selisih hari terlambat
					$t = date_create($r['tgl_kembali']);
					$n = date_create(date('Y-m-d'));
					$terlambat = date_diff($t, $n);
					$hari = $terlambat->format("%a");

					// menghitung denda
					$denda = $hari * 1000;
				?>

				<tr>
					<td><?= $no++ ?></td>
					<td><?= $r['tgl_pinjam'] ?></td>
					<td><?= $r['tgl_kembali'] ?></td>
					<td><?= $hari ?></td>
					<td><?= $denda ?></td>
				</tr>

				<?php
				}
				?>

			</table>
		</div>
	</div>
</div>

</body>
</html>
