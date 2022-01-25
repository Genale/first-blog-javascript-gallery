<?php
// Anslut till databasen
require_once "src/init.php";

// Aktivera error-meddelanden
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (is_post_request()) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!validate_input($username, $password)) {
        echo "No empty fields allowed.";
        return;
    }

    if ($errors) {
        redirect_with('login.php', ['errors' => $errors, 'inputs' => $inputs]);
    }

    // if login fails
    if (!login($inputs['username'], $inputs['password'])) {

        $errors['login'] = 'Invalid username or password';

        redirect_with('login.php', [
            'errors' => $errors,
            'inputs' => $inputs
        ]);
    }
    // login successfully
    redirect_to('index.php');
}
