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
        <div class="card px-4 pb-5">
            <div class="card-body">
                <div class="card-header items-header mb-3" style="background-color: white;">
                    <h5><b>Hasil Pencarian Genre: <?php echo ucfirst($id); ?></b></h5>
                </div>
                <div class="container-fluid">
                    <div class="row justify-content-around">
                        <?php
//query to get film data based on keyword
$sql = "SELECT * FROM film WHERE FILM_GENRE LIKE '%$id%'";
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
        $film_wiki = $row["FILM_WIKI"];

        if ($film_year == 0)
          {
            $film_year = "?";
          }

        if ($film_duration == 0)
          {
            $film_duration = "?";
          }

        include_once "simple_html_dom.php";
        // Create DOM from URL or file
        if (!empty($film_wiki))
          {
            $html = file_get_html($film_wiki);
            $wiki_image = $html->find('img[class="thumbborder"]', 0);
            if (!empty($wiki_image))
              {
                $film_image = $wiki_image->src;
                if (strpos($wiki_image->src, "commons") !== false)
                  {
                    $film_image = " ";
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

            $film_summary = "";
            foreach ($init_summary as $part)
              {
                $film_summary .= strip_tags($part);
              }

            $film_summary = preg_replace("`&(amp;)?#?[a-z0-9]+;`i", "", $film_summary);
            $film_summary = preg_replace("/\.[0-9]+/", ".", $film_summary);

            $html->clear();
            unset($html);
          }
?>
                        <div class="col-md-3 mt-2">
                            <form action="" method="get">
                                <div class="card film_card">
                                    <a href="fdetail.php?id=<?php echo $film_id; ?>" class="card_link" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="<?php
        echo $film_image;
        unset($film_image);
?>" class="card-img-top" onerror="this.onerror=''; this.src='img/no_image.png';">
                                        <div class="card-body">
                                            </i>
                                            <h5 class="primary card-title"><?php echo $film_title; ?><h6
                                                    class="secondary card-title ">
                                                    <?php echo $film_year; ?></h6>
                                            </h5>
                                            <span class="card_text py-3">
                                                <h6><?php
        echo mb_strimwidth($film_summary, 0, 125, "...");
        unset($film_summary);
?></h6>
                                            </span>
                                            <span class="card_info">&nbsp;</span>
                                            <span class="card_info float-end"><i class="fa fa-clock-o"
                                                    aria-hidden="true"></i>
                                                <?php echo $film_duration; ?> m</span>
                                        </div>
                                    </a>
                                </div>
                            </form>
                        </div>

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