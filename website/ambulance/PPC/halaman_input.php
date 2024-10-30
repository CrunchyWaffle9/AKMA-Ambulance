<?php include ("inc_header.php") ?>
<?php

$nama = "";
$no_telp = "";
$keluhan = "";
$jenis_kerusakan = "";
$jenis_perbaikan = "";
$kategori_perbaikan = "";
$estimasi_waktu = "";
$error = "";
$sukses = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

if($id != ""){
    $sql1 = "select * from complaints where id = '$id'";
    $q1   = mysqli_query($koneksi, $sql1);
    $r1   = mysqli_fetch_array($q1);
    $nama= $r1['nama'];
    $no_telp = $r1['no_telp'];
    $keluhan = $r1['keluhan'];
    $jenis_kerusakan = $r1['jenis_kerusakan'];
    $jenis_perbaikan = $r1['jenis_perbaikan'];
    $kategori_perbaikan = $r1['kategori_perbaikan'];
    $estimasi_waktu = $r1['estimasi_waktu'];

    if($nama == ''){
        $error = "Data tidak ditemukan";
    }

}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $no_telp = $_POST['no_telp'];
    $keluhan = $_POST['keluhan'];
    $kategori_perbaikan = $_POST['kategori_perbaikan'];
    $jenis_kerusakan = $_POST['jenis_kerusakan'];
    $jenis_perbaikan = $_POST['jenis_perbaikan'];
    $estimasi_waktu = $_POST['estimasi_waktu'];

    if ($nama == '' or $keluhan == '') {
        $error = "Silahkan masukan semua data";
    }

    if (empty($error)) {
        // Menghitung estimasi waktu berdasarkan antrian
        $sql_queue = "SELECT * FROM complaints ORDER BY tgl_isi ASC";
        $result = mysqli_query($koneksi, $sql_queue);
        $complaints = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $complaints[] = $row;
        }
    
        $current_date = new DateTime();
        $repair_capacity = 5; // Kapasitas reparasi sekaligus
        $repair_times = [];
    
        foreach ($complaints as $index => $row) {
            if ($index < $repair_capacity) {
                $repair_times[] = $row['estimasi_waktu'];
            } else {
                $min_time = min(array_slice($repair_times, -$repair_capacity));
                $current_date = new DateTime($min_time);
    
                $current_category = $row['kategori_perbaikan'];
                if ($current_category == 'minor') {
                    $current_date->modify('+1 day');
                } elseif ($current_category == 'sedang') {
                    $current_date->modify('+5 days');
                } elseif ($current_category == 'major') {
                    $current_date->modify('+8 days');
                }
    
                $repair_times[] = $current_date->format('Y-m-d');
            }
        }
    
        // Menghitung estimasi waktu untuk perbaikan baru
        $min_time = min(array_slice($repair_times, -$repair_capacity));
        $current_date = new DateTime($min_time);
    
        if ($kategori_perbaikan == 'minor') {
            $current_date->modify('+1 day');
        } elseif ($kategori_perbaikan == 'sedang') {
            $current_date->modify('+5 days');
        } elseif ($kategori_perbaikan == 'major') {
            $current_date->modify('+8 days');
        }
    
        $estimasi_waktu = $current_date->format('Y-m-d');
    
        if ($id != "") {
            $sql1 = "UPDATE complaints SET 
                        nama = '$nama',
                        no_telp = '$no_telp',
                        keluhan = '$keluhan',
                        jenis_kerusakan = '$jenis_kerusakan',
                        jenis_perbaikan = '$jenis_perbaikan',
                        kategori_perbaikan = '$kategori_perbaikan',
                        estimasi_waktu = '$estimasi_waktu',
                        tgl_isi = NOW()
                     WHERE id = '$id'";
        } else {
            $sql1 = "INSERT INTO complaints (nama, no_telp, keluhan, jenis_kerusakan, jenis_perbaikan, kategori_perbaikan, estimasi_waktu, tgl_isi) 
                     VALUES ('$nama', '$no_telp', '$keluhan', '$jenis_kerusakan', '$jenis_perbaikan', '$kategori_perbaikan', '$estimasi_waktu', NOW())";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Sukses memasukan data";
        } else {
            $error = "Gagal memasukan data";
        }
    }
}

?>

<h1>Halaman PPC Input Estimasi Waktu</h1>
<div class="mb-3-row">
    <a href="halaman.php">
        << kembali ke dashboard SPV</a>
</div>

<?php
if ($error) {
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php
}
?>

<?php
if ($sukses) {
?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php
}
?>

<form action="" method="post">
    <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" value="<?php echo $nama ?>" name="nama">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telfon</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="no_telp" value="<?php echo $no_telp ?>" name="no_telp">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="keluhan" class="col-sm-2 col-form-label">Keluhan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="keluhan" value="<?php echo $keluhan ?>" name="keluhan">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jenis_kerusakan" class="col-sm-2 col-form-label">Jenis Kerusakan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenis_kerusakan" value="<?php echo $jenis_kerusakan ?>" name="jenis_kerusakan">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jenis_perbaikan" class="col-sm-2 col-form-label">Jenis Perbaikan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenis_perbaikan" value="<?php echo $jenis_perbaikan ?>" name="jenis_perbaikan">
        </div>
    </div>
    <div class="mb-3 row">
    <label for="kategori_perbaikan" class="col-sm-2 col-form-label">Kategori Perbaikan</label>
        <div class="col-sm-10">
            <select class="form-control" id="kategori_perbaikan" name="kategori_perbaikan">
                <option value="minor" <?php if ($kategori_perbaikan == 'minor') echo 'selected'; ?>>Minor</option>
                <option value="sedang" <?php if ($kategori_perbaikan == 'sedang') echo 'selected'; ?>>Sedang</option>
                <option value="major" <?php if ($kategori_perbaikan == 'major') echo 'selected'; ?>>Major</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="estimasi_waktu" class="col-sm-2 col-form-label">Estimasi Waktu</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="estimasi_waktu" name="estimasi_waktu" value="<?php echo $estimasi_waktu; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </div>
</form>
<?php include ("inc_footer.php") ?>

<script>
function updateEstimasiWaktu() {
    const kategori = document.getElementById('kategori_perbaikan').value;
    let estimasiWaktu = '';
    const startDate = new Date(document.getElementById('last_estimasi_waktu').value);

    if (kategori === 'minor') {
        const endDate1 = new Date(startDate);
        endDate1.setDate(startDate.getDate() + 1);
        const endDate2 = new Date(startDate);
        endDate2.setDate(startDate.getDate() + 2);
        estimasiWaktu = `${endDate1.toLocaleDateString('en-CA')} sampai ${endDate2.toLocaleDateString('en-CA')}`;
    } else if (kategori === 'sedang') {
        const endDate1 = new Date(startDate);
        endDate1.setDate(startDate.getDate() + 3);
        const endDate2 = new Date(startDate);
        endDate2.setDate(startDate.getDate() + 7);
        estimasiWaktu = `${endDate1.toLocaleDateString('en-CA')} sampai ${endDate2.toLocaleDateString('en-CA')}`;
    } else if (kategori === 'major') {
        const endDate = new Date(startDate);
        endDate.setDate(startDate.getDate() + 7);
        estimasiWaktu = `> ${endDate.toLocaleDateString('en-CA')}`;
    }

    document.getElementById('estimasi_waktu').value = estimasiWaktu;
}

// Initialize the estimasi waktu on page load based on the current selection
document.addEventListener('DOMContentLoaded', function() {
    updateEstimasiWaktu();
});
</script>
