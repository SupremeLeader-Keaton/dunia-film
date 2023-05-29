<?php
session_start();
error_reporting(error_reporting() & ~E_NOTICE);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BOOTSTRAP & FONTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/logo.jpeg">

    <title>Dunia Film</title>
</head>

<body>
    <button type="button" class="btn btn-floating btn-lg" id="btn-back-to-top">
        <i class="fa fa-arrow-up"></i>
    </button>

    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="img/logo.png" alt="" style="width: 89px; height: 50px;"></a>

            <div id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-medium">
                    <li class="nav-item">
                        <a class="nav-link text-left text-white fs-6" href="panel.php">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i> ADMIN</a>
                    </li>
                </ul>

            </div>
            <form id="mySearchForm" class="d-flex" action="panel.php" method="get">
                <input class="form-control me-2 outline-danger" type="text"
                    placeholder="Film, Artis, Sutradara, Rumah Produksi, dll." aria-label="Search" name="search"
                    required>
                <button id="mySearchButton" class="btn btn-outline-light" type="submit" name="submit"><span><i
                            class="fa fa-search" aria-hidden="true"></i></span><span id="mySearchButtonText"
                        class="fs-6">
                        Cari</span></button>
            </form>
        </div>
    </nav>


    <?php
include_once "conn.php";
if (count($_POST) > 0)
  {
    mysqli_query($conn, "DELETE FROM cast WHERE PERSON_ID = '" . $_POST['del_person'] . "' AND FILM_ID = '" . $_POST['del_film'] . "'");
    $message = "DEL";
  }
?>

    <section>
        <div class="card px-4 pb-3">
            <div class="card-body">
                <div class="card-header items-header mb-3" style="background-color: white;">
                    <h5><b>Penghapusan Data Casting</b></h5>
                </div>
                <?php if (isset($message))
  {
    echo "<div class='alert alert-success'>
<b>Data Casting Berhasil Dihapus</b>
</div>";
  } ?>

                <form method="post" action="">
                    <div class="mb-3">
                        <label class="form-label">ID Film (Dunia Film ID)</label>
                        <input type="number" class="form-control" name="del_film" maxlength="4">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID Individu (Dunia Film ID)</label>
                        <input type="number" class="form-control" name="del_person" maxlength="4">
                    </div>
                    <button type="submit" name="submit" value="Submit" class="btn btn-danger">Hapus</button><a
                        href="panel.php" class="btn btn-warning float-end" role="button"
                        aria-disabled="true">Kembali</a>
                </form>
                <br>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <footer class="text-center text-white">
        <div class="container p-4">
            <section class="mb-4">
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-phone"></i></a>

                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-envelope"></i></a>

                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-twitter"></i></a>

                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fa fa-instagram"></i></a>
            </section>
            <section class="mb-4">
                <p>
                    Dunia Film adalah sebuah proyek situs basis data yang dikembangkan oleh Kelompok 1 - 2SIPA dari UIB.
                </p>
            </section>
        </div>
        <div class="text-center p-3" style="background-color: #680700;">
            ©2022 Kelompok 1 - 2SIPA
        </div>
    </footer>


    <!-- JS -->
    <script type="module">
    import {
        Toast
    } from 'bootstrap.esm.min.js'
    Array.from(document.querySelectorAll('.toast'))
        .forEach(toastNode => new Toast(toastNode))
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    let mybutton = document.getElementById("btn-back-to-top");

    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 80 ||
            document.documentElement.scrollTop > 80
        ) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    </script>
</body>

</html>