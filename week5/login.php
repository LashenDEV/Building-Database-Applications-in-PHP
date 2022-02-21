<?php
session_start();
if (isset($_POST['login'])) {
    if (empty($_POST['email']) && empty($_POST['pass'])) {
        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    } else {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        if (!strpos($_POST['email'], "@")) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        } else {
            if (md5($pass) == "218140990315bb39d948a523d61549b4") {
                $_SESSION['user'] = $email;
                header("Location: index.php");
                return;
            }
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            return;
        }
    }
}
?>
<html>
<head>
    <title>83d53270</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Please Log In</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        Username <input type="text" name="email"><br/><br/>
        Password <input type="password" name="pass"><br/><br/>
        <input type="submit" name="login" value="Log In">
        <a href="index.php">Cancel</a>
    </form>
    For a password hint, view source and find a password hint in the HTML comments.
</div>

</body>
</html>
