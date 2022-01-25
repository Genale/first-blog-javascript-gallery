<?php
// Aktivera error-meddelanden
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$GLOBALS["root_dir"] = $_SERVER['DOCUMENT_ROOT'] . "/first-blog-javascript-gallery";

function connectToDatabase()
{
    // connect to database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "first_blog";

    try {
        $the_pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        return $the_pdo;
    } catch (PDOException $e) {
        echo "connection failed" . $e->getMessage();
        return;
    }
}

// start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (is_user_logged_in()) {
    // Definiera variabler
    $username = $_SESSION['username'];
    
}

function postContactForm($name, $mail, $message)
{

    try {
        $pdo = connectToDatabase();

        $sql = "INSERT INTO contact_form (Name, Mail, Message) VALUES (:name, :mail, :message)";
        // use exec() because no results are returned
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':name' => $name, ':mail' => $mail, ':message' => $message));
        echo "New message sent successfully";
        return true;
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
        return false;
    }
}

// användbara funktioner
function find_user_by_username(string $username)
{
    $sql = 'SELECT username, password
            FROM users
            WHERE username=:username';

    $pdo = connectToDatabase();

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function is_user_logged_in()
{
    if (empty($_SESSION)) {
        return false;
    } else {
        return true;
    }
}

function is_post_request()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return true;
    } else {
        return false;
    }
}

function login(string $username, string $password): bool
{
    $user = find_user_by_username($username);

    // if user found, check the password
    if ($user && password_verify($password, $user['password'])) {

        // prevent session fixation attack
        session_regenerate_id();

        // set username in the session
        $_SESSION['username'] = $user['username'];

        header("Refresh:0");

        return true;
    }

    return false;
}

function logout()
{
    unset($_SESSION["username"]);
    header("Refresh:0");
}

// 1. skapa en funktion som tar in username och password. Den ska heta "validate_input"
// kolla ifall username eller password är tom. I så fall, return false, annars true.
function validate_input(string $username, string $password): bool
{
    if (empty($username) || empty($password)) {
        return false;
    } else {
        return true;
    }
}
