<?php // Do not put any HTML above this line

session_start();

if (isset($_POST['logout'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

$message = false;  // If we have no POST data

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];

    unset($_SESSION['message']);
}

// Check to see if we have some POST data, if we do process it
if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['message'] = "Email and password are required";
        header("Location: login.php");
        return;
    } else {
        $pass = htmlentities($_POST['pass']);
        $email = htmlentities($_POST['email']);

        if ((strpos($email, '@') === false)) {
            $_SESSION['message'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        } else {
            $check = hash('md5', $salt . $pass);
            if ($check == $stored_hash) {
                // Redirect the browser to view.php
                error_log("Login success " . $email);

                $_SESSION['name'] = $email;

                header("Location: view.php");
                return;
            } else {
                error_log("Login fail " . $pass . " $check");
                $_SESSION['message'] = "Incorrect password";

                header("Location: login.php");
                return;
            }
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
    <title>f59a9d18</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    // Note triple not equals and think how badly double
    // not equals would work here...
    if ($message !== false) {
        // Look closely at the use of single and double quotes
        echo(
            '<p style="color: red;" class="col-sm-10 col-sm-offset-2">' .
            htmlentities($message) .
            "</p>\n"
        );
    }
    ?>
    <form method="post" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-3">
                <input class="form-control" type="text" name="email" id="email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pass">Password:</label>
            <div class="col-sm-3">
                <input class="form-control" type="text" name="pass" id="pass">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
                <input class="btn btn-primary" type="submit" value="Log In">
                <input class="btn" type="submit" name="logout" value="Cancel">
            </div>
        </div>
    </form>
    <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
        <!-- Hint: The password is the four character sound a cat
        makes (all lower case) followed by 123. -->
    </p>
</div>
</body>
</html>