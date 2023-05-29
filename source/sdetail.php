<?php
session_start();
error_reporting(error_reporting() & ~E_NOTICE);
require "conn.php";
$id = $_GET["id"];
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
                        <a class="nav-link text-left text-white fs-6" href="help.html">
                            <i class="fa fa-question-circle" aria-hidden="true"></i> Bantuan</a>
                    </li>
                </ul>

            </div>
            <form id="mySearchForm" class="d-flex" action="search.php" method="get">
                <input class="form-control me-2 outline-danger" type="text"
                    placeholder="Cari FILM / ARTIS / SUTRADARA / STUDIO hanya di Dunia Film" aria-label="Search"
                    name="search" required>
                <button id="mySearchButton" class="btn btn-outline-light" type="submit" name="submit"><span><i
                            class="fa fa-search" aria-hidden="true"></i></span><span id="mySearchButtonText"
                        class="fs-6">
                        Cari</span></button>
            </form>
        </div>
    </nav>

    <section>
        <div class="card section-intro px-4 ">
            <div class="card-body ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mt-3">
                            <?php
$sql = "SELECT * FROM studio WHERE FILM_STUDIO = '$id' ";
//execute query
$res = mysqli_query($conn, $sql);
//row presence check
$count = mysqli_num_rows($res);

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
            $wiki_image = $html->find('img[decoding="async"]', 0);
            if (!empty($wiki_image))
              {
                $Studio_image = $wiki_image->src;
                if (strpos($wiki_image->src, "clapperboard") !== false || strpos($wiki_image->src, "microphone") !== false || strpos($wiki_image->src, "Soekarno") !== false || strpos($wiki_image->src, "Leistungen") !== false || strpos($wiki_image->src, "Flag_of_Indonesia") !== false || strpos($wiki_image->src, "bookmark_silver") !== false || strpos($wiki_image->src, "icon_edit") !== false)
                  {
                    $studio_image = " ";
                  }
              }
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
                            <form action="" method="get">

                                <div class="card-body row m-2">
                                    <div class="col-md-3" style="height:auto">
                                        <img src="<?php
        echo $studio_image;
        unset($studio_image);
?>" class="img-fluid px-2 ratio ratio-9x16" onerror="this.onerror=''; this.src='img/no_image.png';">
                                    </div>
                                    <div class="col-md-9">
                                        <h2 class="primary px-2"><b><?php echo $studio_name; ?></b></h2>
                                        <h4 class="secondary px-2">

                                        </h4>
                                        <h5 class="secondary px-2" style="text-align:justify;">
                                            <?php echo $studio_summary;
        unset($studio_summary);
?>
                                        </h5>
                                    </div>
                                </div>
                        </div>


                        </form>
                    </div>

                    <?php
      }
  }
else
  {
  }
?>
                </div>
            </div>


            <div class="card shadow mx-3 mb-5">
                <div class="card-body m-2">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <h4 class="primary pb-3 text-center">Film Yang Diproduksi</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col my-4 d-flex justify-content-center">
                            <?php
$sql = "SELECT s.FILM_STUDIO, f.FILM_ID, f.FILM_TITLE, f.FILM_YEAR, f.FILM_WIKI FROM studio as s INNER JOIN film AS f ON f.FILM_STUDIO = s.FILM_STUDIO WHERE s.FILM_STUDIO = '$id' LIMIT 5;";
//execute query
$res = mysqli_query($conn, $sql);
//row presence check
$count = mysqli_num_rows($res);
if ($res > 0)
  {
    while ($row = mysqli_fetch_assoc($res))
      {

        $film_id = $row["FILM_ID"];
        $film_title = $row["FILM_TITLE"];
        $film_year = $row["FILM_YEAR"];
        $film_wiki = $row["FILM_WIKI"];

        if (strlen($film_title) < 22)
          {
            $film_title = $film_title . "<br>&nbsp;";
          }

        include_once "simple_html_dom.php";
        // Create DOM from URL or file
        if (!empty($film_wiki))
          {
            $html = file_get_html($film_wiki);
            $wiki_image = $html->find('img[decoding="async"]', 0);
            if (!empty($wiki_image))
              {
                $film_image = $wiki_image->src;
                if (strpos($wiki_image->src, "clapperboard") !== false || strpos($wiki_image->src, "microphone") !== false || strpos($wiki_image->src, "Soekarno") !== false || strpos($wiki_image->src, "Leistungen") !== false || strpos($wiki_image->src, "Flag_of_Indonesia") !== false || strpos($wiki_image->src, "bookmark_silver") !== false)
                  {
                    $film_image = " ";
                  }
              }

            $html->clear();
            unset($html);
          }
?>

                            <form action="" method="get">
                                <div class="col">
                                    <div class="card home_card">
                                        <a href="fdetail.php?id=<?php echo $film_id; ?>">
                                            <img src="<?php
        echo $film_image;
        unset($film_image);
?>" class="card-img-top" onerror="this.onerror=''; this.src='img/no_image.png';">
                                            <div class="card-body">
                                                </i>
                                                <h5 class="primary card-title">
                                                    <?php echo $film_title; ?>
                                                    <h6 class="secondary card-title ">
                                                        <?php echo $film_year; ?>
                                                    </h6>
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </form>
                            <?php
      }
  }
else
  {
?>

                            <?php
  }
?>
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