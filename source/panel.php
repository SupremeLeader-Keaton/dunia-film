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
                    placeholder="Cari Film, Artis, Sutradara, atau Studio" aria-label="Search" name="search" required>
                <button id="mySearchButton" class="btn btn-outline-light" type="submit" name="submit"><span><i
                            class="fa fa-search" aria-hidden="true"></i></span><span id="mySearchButtonText"
                        class="fs-6">
                        Cari</span></button>
            </form>
        </div>
    </nav>


    <section>
        <div class="card px-4">
            <div class="card-body">

                <h5><b>Tambah / Hapus Daftar Casting Film:</b>
                    <div class="float-end"><a href="ccreate.php" class="btn btn-primary btn-sm btn-success" role="button"
                            aria-disabled="true">Tambah Casting</a>&nbsp;<a href="cdelete.php"
                            class="btn btn-primary btn-sm btn-danger" role="button" aria-disabled="true">Hapus Casting</a></div>
                </h5>

            </div>
        </div>

        <div class="card px-4 pb-3">
            <div class="card-body">
                <div class="card-header items-header mb-3" style="background-color: white;">
                    <h5><b>Hasil Pencarian Film</b>&nbsp;<a href="fcreate.php" class="btn btn-primary btn-sm float-end"
                            role="button" aria-disabled="true">Tambah Baru</a></h5>
                </div>
                <div class="container-fluid">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Durasi (m)</th>
                                <th scope="col">Studio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
require "conn.php";
//get search keyword
$search = $_GET["search"];
//query to get film data based on keyword
$sql = "SELECT * FROM film WHERE FILM_TITLE LIKE '%$search%' LIMIT 12";
//execute query
$res = mysqli_query($conn, $sql);
//row presence check
$count = mysqli_num_rows($res);
//if data(row) exist, then
if ($count > 0)
  {
    while ($row = mysqli_fetch_assoc($res))
      {

        $film_id = $row["FILM_ID"];
        $film_title = $row["FILM_TITLE"];
        $film_year = $row["FILM_YEAR"];
        $film_duration = $row["FILM_DURATION"];
        $film_production = $row["FILM_STUDIO"];

        if ($film_year == 0)
          {
            $film_year = "?";
          }

        if ($film_duration == 0)
          {
            $film_duration = "?";
          }

?>

                            <tr>
                                <th scope="row"><?php echo $film_id; ?></th>
                                <td><?php echo $film_title; ?></td>
                                <td><?php echo $film_year; ?></td>
                                <td><?php echo $film_duration; ?></td>
                                <td><?php echo $film_production; ?></td>
                                <td><a href="fdetail.php?id=<?php echo $film_id; ?>" class="mr-3" title="Detil"
                                        data-toggle="tooltip" target="_blank" rel="noopener noreferrer"><span
                                            class="fa fa-eye"></span></a></td>
                                <td><a href="fupdate.php?id=<?php echo $film_id; ?>" class="mr-3" title="Ubah"
                                        data-toggle="tooltip"><span class="fa fa-pencil"></span></a></td>
                                <td><a href="fdelete.php?id=<?php echo $film_id; ?>" class="mr-3" title="Hapus"
                                        data-toggle="tooltip"><span class="fa fa-trash"></span></a></td>
                            </tr>

                            <?php
      }
  }
else
  {
    echo "<div class='alert alert-warning'>
            Tidak ada judul film yang sesuai dengan kata kunci yang diberikan.
            </div>";
  }
?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card px-4 pb-3">
            <div class="card-body">
                <div class="card-header items-header mb-3" style="background-color: white;">
                    <h5><b>Hasil Pencarian Artis & Sutradara</b><a href="pcreate.php"
                            class="btn btn-primary btn-sm float-end" role="button" aria-disabled="true">Tambah Baru</a>
                    </h5>
                </div>
                <div class="container-fluid">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Pekerjaan</th>
                                <th scope="col">Tgl. Lahir</th>
                                <th scope="col">J. Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
require "conn.php";
//get search keyword
$search = $_GET["search"];
//query to get film data based on keyword
$sql = "SELECT * FROM person WHERE PERSON_NAME LIKE '%$search%' LIMIT 12";
//execute query
$res = mysqli_query($conn, $sql);
//row presence check
$count = mysqli_num_rows($res);
//if data(row) exist, then
if ($count > 0)
  {
    while ($row = mysqli_fetch_assoc($res))
      {

        $person_id = $row["PERSON_ID"];
        $person_name = $row["PERSON_NAME"];
        $person_dob = $row["PERSON_DOB"];
        $person_sex = $row["PERSON_SEX"];
        $person_type = $row["PERSON_TYPE"];

        if (empty($person_dob))
          {
            $person_dob = "?";
          }

        if ($person_sex == 1)
          {
            $person_sex = "Laki-Laki";
          }
        else
          {
            $person_sex = "Perempuan";
          }

?>
                            <tr>
                                <th scope="row"><?php echo $person_id; ?></th>
                                <td><?php echo $person_name; ?></td>
                                <td><?php echo $person_type; ?></td>
                                <td><?php echo $person_dob; ?></td>
                                <td><?php echo $person_sex; ?></td>
                                <td><a href="pdetail.php?id=<?php echo $person_id; ?>" class="mr-3" title="Detil"
                                        data-toggle="tooltip" target="_blank" rel="noopener noreferrer"><span
                                            class="fa fa-eye"></span></a></td>
                                <td><a href="pupdate.php?id=<?php echo $person_id; ?>" class="mr-3" title="Ubah"
                                        data-toggle="tooltip"><span class="fa fa-pencil"></span></a></td>
                                <td><a href="pdelete.php?id=<?php echo $person_id; ?>" class="mr-3" title="Hapus"
                                        data-toggle="tooltip"><span class="fa fa-trash"></span></a></td>
                            </tr>

                            <?php
      }
  }
else
  {
    echo "<div class='alert alert-warning'>
            Tidak ada nama artis atau sutradara yang sesuai dengan kata kunci yang diberikan.
            </div>";
  }
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card px-4 pb-3">
            <div class="card-body">
                <div class="card-header items-header mb-3" style="background-color: white;">
                    <h5><b>Hasil Pencarian Studio</b><a href="screate.php" class="btn btn-primary btn-sm float-end"
                            role="button" aria-disabled="true">Tambah Baru</a></h5>
                </div>
                <div class="container-fluid">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
require "conn.php";
//get search keyword
$search = $_GET["search"];
//query to get film data based on keyword
$sql = "SELECT * FROM studio WHERE FILM_STUDIO LIKE '%$search%' LIMIT 4";
//execute query
$res = mysqli_query($conn, $sql);
//row presence check
$count = mysqli_num_rows($res);
//if data(row) exist, then
if ($count > 0)
  {
    while ($row = mysqli_fetch_assoc($res))
      {

        $studio_name = $row["FILM_STUDIO"];
        $studio_wiki = $row["STUDIO_WIKI"];

        include_once "simple_html_dom.php";
        // Create DOM from URL or file
        if (!empty($studio_wiki))
          {
            $html = file_get_html($studio_wiki);

            $init_summary = [];
            foreach ($html->find("p") as $paragraph)
              {
                $init_summary[] = $paragraph;
              }
            $remove_top = array_shift($init_summary);
            $remove_bottom = array_pop($init_summary);
            $get_about = array_shift($init_summary);

            $studio_summary = "";
            foreach ($init_summary as $part)
              {
                $studio_summary .= strip_tags($part);
              }

            $studio_summary = preg_replace("`&(amp;)?#?[a-z0-9]+;`i", "", $studio_summary);
            $studio_summary = preg_replace("/\.[0-9]+/", ".", $studio_summary);

            $html->clear();
            unset($html);
          }
?>
                            <tr>
                                <th class="fw-normal"><?php echo $studio_name; ?></th>
                                <td><?php
        echo mb_strimwidth($studio_summary, 0, 120, "...");
        unset($studio_summary);
?></td>
                                <td><a href="sdetail.php?id=<?php echo $studio_name; ?>" class="mr-3" title="Detil"
                                        data-toggle="tooltip" target="_blank" rel="noopener noreferrer"><span
                                            class="fa fa-eye"></span></a></td>
                                <td><a href="sdelete.php?id=<?php echo $studio_name; ?>" class="mr-3" title="Hapus"
                                        data-toggle="tooltip"><span class="fa fa-trash"></span></a></td>
                            </tr>

                            <?php
      }
  }
else
  {
    echo "<div class='alert alert-warning'>
            Tidak ada nama studio film yang sesuai dengan kata kunci yang diberikan.
            </div>";
  }
?>
                        </tbody>
                    </table>
                </div>
            </div>
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