<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My contact information</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="./bloggposter-style.css" />
</head>

<body>
    <?php include_once '../components/header-nav.php'; ?>

    <?php
    if (is_user_logged_in()) { ?>
        <div id="create-blogpost">
            <form method="post">
                <div id="bloggposter">
                    <label for="title">Your bloggpost's title:</label><br />
                    <input type="text" id="text" name="title" /><br />
                    <label for="text">Your bloggpost:</label> <br />
                    <textarea name="content" rows="3" cols="25"></textarea>
                    <br />
                    <label for="bloggpost">Choose between to post and to create a draft:</label>
                    <select id="is-draft" name="is-draft">
                        <option value="draft">Draft</option>
                        <option value="post">To post</option>
                    </select><br />
                    <input style="margin-top: 15px;" type="submit" name="bloggposter" value="Publish" />
                </div>
            </form>
        </div>
    <?php } ?>

    <?php
    if (is_post_request()) {

        // bloggposter-form
        if (isset($_POST["bloggposter"])) {
            $user = $username; // finns i init.php
            $title = $_POST['title'];
            $content = $_POST['content'];
            $draft = $_POST['is-draft'];

            if ($draft === "draft") {
                $draft = 1;
            } else if ($draft === "post") {
                $draft = 0;
            } else {
                echo "WRONG DRAFT!";
            }

            if (empty($content) || empty($title)) {
                echo "FEL! Fyll i alla fält.";
            } else {
                try {
                    $pdo = connectToDatabase();
                    $sql = "INSERT INTO blogposts(user, title, content, draft) VALUES(:user, :title, :content, :draft)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(':user' => $user, ':title' => $title, ':content' => $content, ':draft' => $draft));
                    echo " It is successfully uploaded.";
                } catch (PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }
            }
        } else if (isset($_POST["delete-blogpost"])) {
            if (array_key_exists('delete-blogpost', $_POST)) {
                $blogpost_id = $_POST['blogpost_id'];
                $pdo = connectToDatabase();
                $stmt = $pdo->prepare("DELETE FROM blogposts WHERE id = :id");
                $stmt->bindValue(':id', $blogpost_id);
                $deleted = $stmt->execute();
                $success = $deleted ? "The post was deleted." : "The post could not be deleted.";
            }
        } else if (isset($_POST['save-changes'])) {
            echo "CHANGES WANTS TO BE SAVED!";
            // HÄMTA VILKEN BLOGPOST ID SOM SKA UPPDATERAS
            $id = $_POST['blogpost_id'];
            $draft = $_POST['draft'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            $draft_bool = null;

            if ($draft == "draft") {
                $draft_bool = 1;
            } else {
                $draft_bool = 0;
            }

            echo $draft_bool;

            var_dump($_POST);

            try {
                $pdo = connectToDatabase();
                $sql = "UPDATE blogposts SET title = :title, content = :content, draft = :draft
                        WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':title' => $title, ':content' => $content, ':draft' => $draft_bool, ':id' => $id));
                echo " It is successfully uploaded.";
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }



            /*
            UPDATE blogpost
                    SET user = $user, title = $title, content = $content, draft = $draft,
                        WHERE blogpostId = blogpostId;
                        */
        } else {
            echo "INGEN MATCH";
        }
    }
    ?>


    <?php

    try {
        $pdo = connectToDatabase();
        $sql = "SELECT id, user, title, content,draft FROM blogposts";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $blogposts = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <div id="blogposts">
        <h3> Blogposts</h3>
        <?php
        foreach ($blogposts as $blogpost) {
            $user = $blogpost['user'];
            $title = $blogpost['title'];
            $content = $blogpost['content'];
            $draft = $blogpost['draft'];
            $blogpost_id = $blogpost['id'];

            // om man inte är inloggad ska man inte kunna se inlägg som är Draft.

            if (is_user_logged_in() || $draft === "0") {
        ?>
                <div class="blogpost" id="blogpost-<?php echo $blogpost_id ?>">
                    <p class="user"><?php echo $user ?></p>
                    <p class="title blogpost-data" contenteditable="true"><?php echo $title ?></p>
                    <p class="content blogpost-data" contenteditable="true"><?php echo $content ?></p>
                    <select class="draft blogpost-data" <?php if (!is_user_logged_in()) {
                                                            echo "style=\"display: none;";
                                                        } ?>>
                        <option value="draft">Draft</option>
                        <option value="post" <?php if ($draft == 0) {
                                                    echo "selected";
                                                } ?>>To post</option>
                    </select><br>
                    <form method="post" class="delete-form">
                        <input type="hidden" class="blogpost_id" name="blogpost_id" value="<?php echo $blogpost_id ?>">
                        <input <?php if (!is_user_logged_in()) {
                                    echo "style=\"display: none;";
                                } ?>class="delete" type="submit" name="delete-blogpost" value="delete">
                    </form>
                    <!-- SPARA ÄNDRINGAR FÖR BLOGPOST -->
                    <button <?php if (!is_user_logged_in()) {
                                echo "style=\"display: none;";
                            } ?> class="save-changes" onclick="saveChanges(<?php echo $blogpost_id ?>)">Save changes!</button>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <script>
        /* id = blogpost ID */
        function saveChanges(id) {
            console.log(id);
            let blogpostEl = document.querySelector("#blogpost-" + id);
            let strTitle = blogpostEl.querySelector(".title").innerHTML;
            let strContent = blogpostEl.querySelector(".content").innerHTML;
            let strDraft = blogpostEl.querySelector(".draft").value;

            let toPost = {
                blogpost_id: id,
                "save-changes": "",
                draft: strDraft,
                title: strTitle,
                content: strContent
            };

            post("", toPost);
        }

        /**
         * sends a request to the specified url from a form. this will change the window location.
         * @param {string} path the path to send the post request to
         * @param {object} params the parameters to add to the url
         * @param {string} [method=post] the method to use on the form
         */

        function post(path, params, method = 'post') {

            // The rest of this code assumes you are not using a library.
            // It can be made less verbose if you use one.
            const form = document.createElement('form');
            form.method = method;
            form.action = path;

            for (const key in params) {
                if (params.hasOwnProperty(key)) {
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = key;
                    hiddenField.value = params[key];

                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

        let blogpostDataFieldElements = document.getElementsByClassName("blogpost-data");
        for (blogpostField of blogpostDataFieldElements) {
            let fieldContents = blogpostField.innerHTML;
            // Spara original-värdet
            blogpostField.dataset.originalValue = fieldContents;
        }
    </script>

    <footer>
        <p><i>By Alessandra Sánchez for Medieinstitutet.</i></p>
    </footer>
</body>