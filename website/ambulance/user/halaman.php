<?php include ("inc_header.php") ?>
<?php
$sukses = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure connection to database
include("../inc/inc_koneksi.php");

// Mendapatkan email customer yang sedang login dari sesi
$email = $_SESSION['email'];
?>
<h1>Dashboard Customer</h1>
<p>
    <a href="input.php">
        <input type="button" class="btn btn-primary" value="Input Pesanan Baru" />
    </a>
</p>
<?php
if ($sukses) {
    ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses?>
    </div>
    <?php
}
?>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Masukkan kata kunci" name="katakunci"
            value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari tulisan" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">Antrian</th>
            <th>Customer</th>
            <th>Jenis Kerusakan</th>
            <th>Jenis Perbaikan</th>
            <th>Kategori Perbaikan</th>
            <th>Estimasi Waktu</th>
            <th>Pemberitahuan Perbaikan</th>
            <th>Pemberitahuan Admin</th>
            <th class="col-1">Pay</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 20;
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(nama like '%" . $array_katakunci[$x] . "%' or jenis_perbaikan like '%" . $array_katakunci[$x] . "%' or kategori_perbaikan like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan = "AND (" . implode(" OR ", $sqlcari) . ")";
        }
        $sql1 = "SELECT * FROM complaints WHERE email = '$email' $sqltambahan";
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $mulai = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1  = mysqli_query($koneksi, $sql1);
        $total = mysqli_num_rows($q1);
        $pages = ceil($total / $per_halaman);
        $nomor = $mulai + 1;
        $sql1 = $sql1 . " ORDER BY id ASC LIMIT $mulai, $per_halaman";

        $q1 = mysqli_query($koneksi, $sql1);

        while ($r1 = mysqli_fetch_array($q1)) {
            ?>
            <tr>
                <td><?php echo $nomor++ ?></td> <!-- Increment the $nomor variable correctly -->
                <td><?php echo $r1['nama'] ?></td>
                <td><?php echo $r1['jenis_kerusakan'] ?></td>
                <td><?php echo $r1['jenis_perbaikan'] ?></td>
                <td><?php echo $r1['kategori_perbaikan'] ?></td>
                <td><?php echo $r1['estimasi_waktu'] ?></td>
                <td><?php echo $r1['pemberitahuan_perbaikan'] ?></td>
                <td><?php echo $r1['pemberitahuan_admin'] ?></td>
                <td>
                    <a href="halaman_input.php?id=<?php echo $r1['id']?>">
                    <span class="badge bg-warning text-dark">Pay</span>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
                $cari = (isset($_GET['cari'])) ? $_GET['cari'] : "";
                for($i = 1; $i <= $pages; $i++){
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="halaman.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i?>"><?php echo $i?></a>
                    </li>
                    <?php
                }
        ?>
    </ul>
</nav>
<?php include ("inc_footer.php") ?>
