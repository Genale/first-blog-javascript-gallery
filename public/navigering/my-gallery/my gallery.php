<?php
// Get the image data
$str_images = file_get_contents("./images.json");
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My gallery</title>
  <link rel="stylesheet" href="../../style.css" />
  <link rel="stylesheet" href="./my-gallery-style.css" />
  <script type="text/javascript" src="gallery.js" defer></script>
  <script type="text/javascript" src="images.json"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
  <?php include_once '../../components/header-nav.php'; ?>
  <div class="info-box">
    <h2>My gallery</h2>
    <p>Here is my gallery of photos!</p>
    <p>
      In this gallery you can see pictures that I have been taking every time
      I travel. (I love to travel)
    </p>
    <p>
      The purpouse with this gallery is to share nice and unforgettable
      moments with my readers.
    </p>
  </div>
  <div id="pictures">
    <h2>Pictures of Sintra, Portugal (2021)</h2>
    <div class="country">
      <?php

      ?>
    </div>
    <h2>Pictures of London, United Kingdom (2020)</h2>
    <div class="country"></div>
    <h2>Pictures of Kampala, Uganda (2019)</h2>
    <div class="country"></div>
  </div>
  <footer>
    <p><i>By Alessandra Sánchez for Medieinstitutet.</i></p>
  </footer>
  <div id="dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-description" tabindex="-1" hidden>
    <form class="dialog-content">
      <img id="dialogImage" src="/first-blog-javascript-gallery/public/photos-and-images/uganda-trip-2.jpg" alt="Picture of Uganda" />
      <footer>
        <p id="imageDescription"></p>
        <button id="close-button">close</button>
      </footer>
    </form>
  </div>
</body>

</html>