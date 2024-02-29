<?php
session_start();
include '../config/koneksi.php';
$userid = $_SESSION['userid'];
if ($_SESSION['status'] != 'login') {
    echo "<script>
            alert('Anda belum login!'); 
            location.href='../index.php';
        </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galery Foto</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-2" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a href="home.php" class="nav-link">Home</a>
                    <a href="album.php" class="nav-link">Album</a>
                    <a href="foto.php" class="nav-link">Foto</a>
                </div>
                <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
            </div>
        </div>
    </nav>


    <div class="container mt-3">
        Album:
        <?php
        $album = mysqli_query($koneksi, "SELECT * FROM album where userid='$userid'");
        while ($row = mysqli_fetch_array($album)) { ?>
            <a href="home.php?albumid=<?php echo $row['albumid'] ?>" class="btn btn-outline-primary">
                <?php echo $row['namaalbum'] ?>
            </a>
        <?php } ?>

        <div class="row">

            <?php
            if (isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
                while ($data = mysqli_fetch_array($query)) { ?>
                    <div class="col-md-3 mt-2">
                        <div class="card">
                            <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top"
                                title="<?php echo $data['judulfoto'] ?>" width="200px">
                            <div class="card-footer text-center">

                                <?php
                                $fotoid = $data['fotoid'];
                                $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                if (mysqli_num_rows($ceksuka) == 1) { ?>
                                    <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                                        name="batalsuka"><i class="fa fa-heart"></i></a>
                                <?php } else { ?>
                                    <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                                        name="suka"><i class="fa-regular fa-heart"></i></a>
                                <?php }

                                $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                echo mysqli_num_rows($like) . ' Suka ';
                                ?>

                                <a href=""><i class="fa-regular fa-comment"></i>3 Komentar</a>
                            </div>
                        </div>
                    <?php }
            } else {
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
                while ($data = mysqli_fetch_array($query)) { ?>

                        <div class="col-md-3 mt-2">
                            <div class="card">
                                <img src="../assets/img/<?php echo $data['lokasifile'] ?>" class="card-img-top"
                                    title="<?php echo $data['judulfoto'] ?>" width="200px">
                                <div class="card-footer text-center">

                                    <?php
                                    $fotoid = $data['fotoid'];
                                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                                            name="batalsuka"><i class="fa fa-heart"></i></a>
                                    <?php } else { ?>
                                        <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit"
                                            name="suka"><i class="fa-regular fa-heart"></i></a>
                                    <?php }

                                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                    echo mysqli_num_rows($like) . ' Suka ';
                                    ?>

                                    <a href=""><i class="fa-regular fa-comment"></i>3 Komentar</a>
                                </div>
                            </div>
                        </div>
                    <?php }
            } ?>
            </div>
        </div>
        <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
            <p>&copy; WEBGALLERY_SINTIAA</p>
        </footer>

        <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>