<?php 
include ("inc_header.php"); 
?>

<?php
$sukses = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
$selected_montir = (isset($_GET['montir'])) ? $_GET['montir'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from complaints where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Delete Success";
    }
}
?>

<h1>Dashboard Montir</h1>

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
        <select class="form-select" name="montir">
            <option value="">Pilih Montir</option>
            <option value="Montir 1" <?php if ($selected_montir == "Montir 1") echo "selected"; ?>>Montir 1</option>
            <option value="Montir 2" <?php if ($selected_montir == "Montir 2") echo "selected"; ?>>Montir 2</option>
            <option value="Montir 3" <?php if ($selected_montir == "Montir 3") echo "selected"; ?>>Montir 3</option>
            <option value="Montir 4" <?php if ($selected_montir == "Montir 4") echo "selected"; ?>>Montir 4</option>
            <option value="Montir 5" <?php if ($selected_montir == "Montir 5") echo "selected"; ?>>Montir 5</option>
        </select>
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Search" class="btn btn-secondary" />
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">Antrian</th>
            <th>Customer</th>
            <th>Jenis Kerusakan</th>
            <th>Jenis Perbaikan</th>
            <th>Montir</th>
            <th class="col-1">Act</th>
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
            $sqltambahan = "where " . implode(" or ", $sqlcari);
        }
        if ($selected_montir != '') {
            if ($sqltambahan != "") {
                $sqltambahan .= " and montir = '$selected_montir'";
            } else {
                $sqltambahan = "where montir = '$selected_montir'";
            }
        }
        $sql1 = "select * from complaints $sqltambahan";
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $mulai = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1 = mysqli_query($koneksi, $sql1);
        $total = mysqli_num_rows($q1);
        $pages = ceil($total / $per_halaman);
        $nomor = $mulai + 1;
        $sql1 = $sql1 . " order by id asc limit $mulai, $per_halaman";

        $q1 = mysqli_query($koneksi, $sql1);

        while ($r1 = mysqli_fetch_array($q1)) {
            ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $r1['nama'] ?></td>
                <td><?php echo $r1['jenis_kerusakan'] ?></td>
                <td><?php echo $r1['jenis_perbaikan'] ?></td>
                <td><?php echo $r1['montir'] ?></td>
                <td>
                    <a href="halaman_input.php?id=<?php echo $r1['id']?>">
                    <span class="badge bg-warning text-dark">Input</span>
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
            for ($i = 1; $i <= $pages; $i++) {
                ?>
                <li class="page-item">
                    <a class="page-link" href="halaman.php?katakunci=<?php echo $katakunci ?>&cari=<?php echo $cari ?>&page=<?php echo $i ?>&montir=<?php echo $selected_montir ?>"><?php echo $i ?></a>
                </li>
                <?php
            }
        ?>
    </ul>
</nav>

<?php include ("inc_footer.php") ?>