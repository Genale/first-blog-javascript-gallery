<!DOCTYPE html>
<html lang="en">

<?php
// Aktivera error-meddelanden
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- inloggning: admin, abc -->

<style>
  body {
    color: white;
  }
</style>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Projektarbetet</title>
  <link rel="stylesheet" href="public/style.css" />
</head>

<body>
  <?php include_once 'public/components/header-nav.php'; ?>
  <div class="info-box">
    <h2>Hi and welcome to my blog!</h2>
    <p>
      The theme of the month is the space. I hope you enjoy the following
      interesting articles. Do not forget to subscribe to our website if you
      wish to get updates about new articles.
    </p>
  </div>

  <div id="blog-roll">

    <?php require_once "src/get_blogs.php" ?>

    <div class="blog-roll-item">
      <img src="public/photos-and-images/Nasa bild artikel 1.jpg" alt="Picture of an astronaut on the moon" />
      <div class="title">
        NASA Selects Five U.S. Companies to Mature Artemis Lander Concepts
      </div>
      <div class="description">
        NASA has selected five U.S. companies to help the agency enable a
        steady pace of crewed trips to the lunar surface...
      </div>
      <a href="public/articles/article-1.php">Read more</a>
      <div class="date">Sep 14, 2021</div>
    </div>
    <div class="blog-roll-item">
      <img src="public/photos-and-images/Artikel 2.jpg" alt="Picture of the Soyuz MS-18 crew ship" />
      <div class="title">
        Space Station Crew to Relocate Soyuz, Make Room for New Crewmates
      </div>
      <div class="description">
        Three residents of the International Space Station will take a short
        ride aboard a Soyuz MS-18 spacecraft...
      </div>
      <a href="public/articles/article-2.php">Read more</a>
      <div class="date">Sep 22, 2021</div>
    </div>
    <div class="blog-roll-item">
      <img src="public/photos-and-images/Article 3.jpg" alt="Picture of the arctic sea ice" />
      <div class="title">
        NASA Finds 2021 Arctic Summer Sea Ice 12th-Lowest on Record
      </div>
      <div class="description">
        Sea ice in the Arctic appears to have hit its annual minimum extent on
        Sept. 16, after waning...
      </div>
      <a href="public/articles/article-3.php">Read more</a>
      <div class="date">Sep 22, 2021</div>
    </div>
    <div class="blog-roll-item">
      <img src="public/photos-and-images/Astronomer article 4.jpg" alt="Astronomer Urbain Le Verrier" />
      <div class="title">
        175 Years Ago: Astronomers Discover Neptune, the Eighth Planet
      </div>
      <div class="description">
        On the night of Sept. 23-24, 1846, astronomers discovered Neptune, the
        eighth planet
      </div>
      <a href="public/articles/article-4.php">Read more</a>
      <div class="date">Sep 22, 2021</div>
    </div>
    <div class="blog-roll-item">
      <img src="public/photos-and-images/Huble.jpg" alt="Sparkling starfield" />
      <div class="title">
        Hubble Captures a Cluster in the Heart of the Milky Way
      </div>
      <div class="description">
        This sparkling starfield, captured by the NASA/ESA Hubble Space
        Telescope’s Wide Field Camera 3 and Advanced Camera for Surveys,
        contains the globular cluster ESO 520-21...
      </div>
      <a href="public/articles/article-5.php">Read more</a>
      <div class="date">Sep 24, 2021</div>
    </div>
  </div>
  <footer>
    <p><i>By Alessandra Sánchez for Medieinstitutet.</i></p>
  </footer>
</body>

</html>