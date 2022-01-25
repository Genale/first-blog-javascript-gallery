<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My contact information</title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="./navigering-style.css" />
</head>

<body>
  <?php include_once '../components/header-nav.php'; ?>

  <div class="info-boxes extra-padding">
    <div class="info-box">
      <h2>Contact information</h2>
      <p>
        My mail is asegerfast@gmail.com.
        <br />
        My number is +56 45 32 87 91.
      </p>
    </div>
    <div class="info-box">
      <form method="POST">
        <div class="contact-form">
          <label for="name">Your name:</label><br />
          <input type="text" id="name" name="name" /><br />
          <label for="mail">Your mail address:</label><br />
          <input type="email" id="mail" name="mail" />
          <p>Your message:</p>
          <textarea name="message" rows="3" cols="25"></textarea> <br />
          <input style="margin-bottom: 10px" type="submit" name="send_contact_form" />
      </form>
    </div>
  </div>
  </div>
  <footer>
    <p><i>By Alessandra Sánchez for Medieinstitutet.</i></p>
  </footer>
</body>

</html>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $GLOBALS["root_dir"] . '/PHPMailer-master/src/Exception.php';
require $GLOBALS["root_dir"] . '/PHPMailer-master/src/PHPMailer.php';
require $GLOBALS["root_dir"] . '/PHPMailer-master/src/SMTP.php';

if (is_post_request()) {

  // contact-form

  if (isset($_POST["send_contact_form"])) {
    $name = $_POST['name'];
    $str_email = $_POST['mail'];
    $message = $_POST['message'];

    // 1. kolla ifall name inte är tomt och inte för långt.
    // 2. kolla ifall 

    // Ifall all input är bra, spara det i databasen.

    if (empty($name) || empty($str_email) || empty($message)) {
      echo "FEL! Fyll i alla fält.";
    } else {

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Mailer = "smtp";

      $mail->SMTPDebug  = 1;
      $mail->SMTPAuth   = TRUE;
      $mail->SMTPSecure = "tls";
      $mail->Port       = 587;
      $mail->Host       = "smtp.gmail.com";
      $mail->Username   = "asegerfast@gmail.com";
      $mail->Password   = "hemligtpassword888";

      $mail->IsHTML(true);
      $mail->AddAddress("asegerfast@gmail.com", $name);
      $mail->SetFrom($str_email, $name);
      $mail->Subject = "Contact-form from " . $name;
      $content = "<b>" . $name . "</b>" . " (" . $str_email . ") sent a message: <br>" . $message;

      if (postContactForm($name, $str_email, $message)) {
        $mail->MsgHTML($content);
        if (!$mail->Send()) {
          echo "Error while sending Email.";
          var_dump($mail);
        } else {
          echo "Email sent successfully";
        }
      }
    }
  }
}
?>