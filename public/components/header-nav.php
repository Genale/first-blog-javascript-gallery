<?php
$root_dir = $_SERVER['DOCUMENT_ROOT'] . "/first-blog-javascript-gallery";
include_once($root_dir . '/src/init.php');
?>

<!DOCTYPE html>

<style>
    <?php
    include 'header-nav-style.css';
    ?>
</style>

<div id="dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-description" tabindex="-1" hidden>
    <form method="post" class="dialog-content">
        <h1>Login</h1>
        <p id="empty-credentials" hidden>Alla fält behöver fyllas i. Försök igen.</p>
        <p id="wrong-credentials" hidden>Kunde inte logga in. Kontrollera användaruppgifterna.</p>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <section>
            <button type="submit" name="login">Login</button>
        </section>
        <footer>
            <button id="close-button">close</button>
        </footer>
    </form>
</div>

<script>
    let dialogEl = document.querySelector("#dialog");
    let closeButton = document.querySelector("#close-button");

    closeButton.addEventListener("click", (event) => {
        event.preventDefault();
        dialogEl.hidden = true;
    });

    function showLoginPopup() {
        let dialogEl = document.querySelector("#dialog");
        dialogEl.hidden = false;
    }

    function showLoginPopupEmptyFields() {
        let dialogEl = document.querySelector("#dialog");
        dialogEl.hidden = false;
        let emptyCredentials = document.querySelector('#empty-credentials');
        emptyCredentials.hidden = false;
    }

    function showLoginPopupWrongCredentials() {
        let dialogEl = document.querySelector("#dialog");
        dialogEl.hidden = false;
        dialogEl.querySelector('#wrong-credentials').hidden = false;
    }
</script>

<?php function show_mainpage_button()
{ ?>
    <a class="nav-item" href="/first-blog-javascript-gallery/index.php"> Go back to main page </a>
<?php } ?>

<?php function show_login_logout_button()
{

    $logged_out = !is_user_logged_in();

    if ($logged_out) { ?>
        <button id="btn_login" onclick="showLoginPopup()">Login</button>
    <?php } else { ?>
        <?php if (!empty($_SESSION['username'])) { ?>
            <p>Logged in as: <?php echo $_SESSION['username'] ?></p>
        <?php } ?>
        <form method="post" class="dialog-content">
            <button type="submit" id="btn_logout" name="logout" method="post">Logout</button>
        </form>
    <?php } ?>

<?php } ?>

<?php
$mainpage = '<a class="nav-item" href="/first-blog-javascript-gallery/index.php"> Go back to main page </a>';
$basename = basename($_SERVER['PHP_SELF']);
?>

<header>
    <img id="logo" src="/first-blog-javascript-gallery/public/photos-and-images/Yo.jpg" alt="Webpage's logo" />
    <h1>My one and only blog</h1>
    <h3>by Alessandra Sánchez</h3>
    <?php show_login_logout_button() ?>
</header>
<nav>

    <?php
    if (str_contains($basename, "article")) {
        show_mainpage_button();
    }
    ?>

    <?php
    if ($basename == "about-me.php") {
        show_mainpage_button();
    } else {
        echo '
            <a class="nav-item" href="/first-blog-javascript-gallery/public/navigering/about-me.php">
                About me and this blog
            </a>
            ';
    }
    ?>

    <?php
    if ($basename == "my gallery.php") {
        show_mainpage_button();
    } else {
        echo '
            <a class="nav-item" href="/first-blog-javascript-gallery/public/navigering/my-gallery/my gallery.php">
                My gallery
            </a>
            ';
    }
    ?>

    <?php
    if ($basename == "Contact-info.php") {
        show_mainpage_button();
    } else {
        echo '
            <a class="nav-item" href="/first-blog-javascript-gallery/public/navigering/Contact-info.php">
                Get in touch with us
            </a>
            ';
    }
    ?>

    <?php
    if ($basename == "bloggposter.php") {
        show_mainpage_button();
    } else {
        echo '
            <a class="nav-item" href="/first-blog-javascript-gallery/public/components/bloggposter.php">
                Bloggposter
            </a>
            ';
    }
    ?>
</nav>

<?php
// kolla ifall du kom hit pga en POST-request (inlogg)
if (is_post_request()) {

    // logout

    if (isset($_POST["login"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!validate_input($username, $password)) {
            echo '<script>
                showLoginPopupEmptyFields();
            </script>';
        } else {
            // Om input ser bra ut, försök logga in.
            if (login($username, $password) === false) {
                echo '<script>
            showLoginPopupWrongCredentials();
        </script>';
            }
        }
    } else if (isset($_POST["logout"])) {
        logout();
    }
}

?>