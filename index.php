<?php
$api_key = 'EjHE6aoOfMI0WnIrqta6frI4SDadFZlFY2zlJyiW';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web API NASA</title>

    <!-- CSS Syle -->
    <link rel="stylesheet" href="style.css">

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- CSS AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark fixed-top navbar-dark" data-bs-theme="dark">
        <div class="container-fluid me-5 ms-5">
            <a class="navbar-brand d-flex" href="#">
                <img src="logo2.png" alt="">
                <h1>SpaceInfo</h1>
            </a>
            <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#topics">Topics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#galleries">Galleries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item" style="position: relative;">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <i data-feather="search" style="position: absolute; right: 10px; top: 8px; cursor: pointer;"></i>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="layar-penuh">
        <!-- Header Video -->
        <header id="home">
            <div class="overlay">
                <video autoplay muted loop>
                    <source src="galaksi.mp4" type="video/mp4">
                </video>
                <div class="intro">
                    <h3 class="lead"></h3>
                    <button class="btn" type="submit">LET'S GO</button>
                </div>
            </div>
        </header>

        <!-- About -->
        <section id="about">
            <div class="layar-dalam">
                <h3>About Us</h3>
                <div class="deskripsi">
                    <p class="ringkasan">
                        Welcome to our space-themed website! We are a team of science enthusiasts and space aficionados 
                        who want to share our knowledge and love of space with you. Enjoy the latest and most accurate 
                        information about galaxies, planets, stars, and all things space-related. We hope our website 
                        will captivate your imagination and provide an enjoyable and informative experience.
                    </p>
                </div>
               
                
            </div>
        </section>
    </div>

    <!-- Topics -->
    <section id="topics">
        <h3>News Topics</h3>
        <div class="jumbotron">
            <div class="row">
            <?php

            $topics_query = '';
            $topics_api_url = 'https://images-api.nasa.gov/search?q=' . urlencode($topics_query) . '&media_type=image';

            // lakukan permintaan API menggunakan cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $topics_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $api_key));
            $response = curl_exec($ch);
            curl_close($ch);

            // parsing data JSON yang diterima dari API
            $data = json_decode($response, true);
            // echo '<pre>';
            // var_dump($data);
            // echo '</pre>';

            $hitung = 0;
            foreach ($data['collection']['items'] as $item) {
                if($hitung >=8){
                    break;
                }

                $image_url = $item['links'][0]['href'];
                $title = $item['data'][0]['title'];
                $description = $item['data'][0]['description'];
                $date_created = $item['data'][0]['date_created'];
                ?>

                <div class="card me-5 mb-5" style="width: 20rem;" data-aos="flip-left">
                    <a href="<?php echo $image_url; ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo $image_url ?>" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title ?></h5>
                        <p class="card-text"><?php echo $description ?></p>
                        <div class="card-footer">
                            <small class="text-muted">Last updated <?php echo $date_created ?></small>
                        </div>
                    </div>
                </div>
                <?php
                $hitung++;
                }
                ?>
        </div>
    </section>

    <!-- Galleries -->
    <section id="galleries">
        <h3>Galleries</h3>
        <div class="jumbotron">
            <?php
            // Request data gambar terbaru
            $url_images = 'https://images-api.nasa.gov/search?q=&media_type=image&page=1&year_start=2022&year_end=2023';
            $ch_images = curl_init();
            curl_setopt($ch_images, CURLOPT_URL, $url_images);
            curl_setopt($ch_images, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_images, CURLOPT_HTTPHEADER, array('Authorization: ' . $api_key));
            $result_images = curl_exec($ch_images);
            curl_close($ch_images);

            $data_images = json_decode($result_images, true);
            $images = array_slice($data_images['collection']['items'], 0, 12);
            ?>

            <!-- Menampilkan hasil -->
            <?php
                foreach ($images as $image) {
                    $image_url = $image['links'][0]['href'];
            ?>
                <a href="<?php echo $image_url; ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo $image_url ?>" width="200" height="200" data-aos="zoom-in">
                </a>
            <?php
                }
            ?>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="contact">
      <h3>Contact Us</h3>
      <p>
        Contact us if you have questions about space info.
      </p>

      <div class="row">
        <div class="col-5">
            <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31876.049179470796!2d119.89234283708672!3d-
            2.956959453464392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d93c2721a3a6f0f%3A0x52ebd52f6f12904c!2sKec.
            %20Tallunglipu%2C%20Kabupaten%20Toraja%20Utara%2C%20Sulawesi%20Selatan!5e0!3m2!1sid!2sid!4v1675163416249!5m2!1si
            d!2sid"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referr
            er-when-downgrade"
            class="map"
            ></iframe>
        </div>
        

        <div class="col-5">
            <form action="">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i data-feather="user"></i></span>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Username">
                        <label for="floatingInputGroup1">Username</label>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i data-feather="mail"></i></span>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="floatingInputGroup1" placeholder="Email">
                        <label for="floatingInputGroup1">Email</label>
                    </div>
                </div>
                <div class="form-floating" style="margin-top: 15px;">
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Comments</label>
                </div>
                <button class="btn btn-secondary" type="submit">SEND</button>
            </form>

        </div>
        
      </div>
    </section>

    <!-- Footer -->
    <footer>
      <div class="socials">
        <a href="#"><i data-feather="instagram"></i></a>
        <a href="#"><i data-feather="twitter"></i></a>
        <a href="#"><i data-feather="facebook"></i></a>
      </div>
      <div class="links">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#topics">News Topics</a>
        <a href="#galleries">Galleries</a>
        <a href="#contact">Contact</a>
      </div>
      <div class="credit">
        <p>Create by <a href="#">Merson</a>. | &copy; 2023</p>
      </div>
    </footer>
   
    <!-- Script Boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <!-- Script Feather Icons -->
    <script>
      feather.replace()
    </script>

    <!-- Script GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/TextPlugin.min.js"></script>
        <script>
            gsap.registerPlugin(TextPlugin);
            gsap.to('.lead', {duration: 3.5, text: "Let's Explore Outer Space"});
        </script>

    <!-- Script AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>
</html>


