<?php
require_once "pdo.php";

$salt = 'XyZzy12*_';

if (isset($_POST['login'])) {
    //Check if the username or password filled or no
    if (empty($_POST['who']) || empty($_POST['pass'])) {
        $message = '<label>Email and password are required</label>';

    } else if (isset($_POST['who']) && isset($_POST['pass'])) {
        //Email verification
        if (!strpos($_POST['who'], '@')) {
            $message = '<label>Email must have an at-sign (@)</label>';
        } else {
            $sql = "SELECT name FROM users WHERE email = :email AND password = :password";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(array(
                ':email' => $_POST['who'],
                ':password' => $_POST['pass']
            ));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($row === false) {
                $check = hash('md5', $salt . $_POST['pass']);
                error_log("Login fail " . $_POST['who'] . " $check");
                $message = '<label>Incorrect password</label>';
            } else {
                header("Location: autos.php?name=" . urlencode($_POST['who']));
                error_log("Login success " . $_POST['who']);
            }
        }
    }
}

//Redirection to index.php
if (isset($_POST['cancel'])) {
    header('Location:index.php');
    return;
}

?>
<html>
<head>
    <title>e68cc7c1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
if (isset($message)) {
    echo '<label style="color: red">' . $message . '</label>';
}
?>
<div class="container">
    <h1>Please Log In</h1>
    <form method="post">
        <p>User Name : <input type="text" name="who" size="40"></p>
        <p>Password : <input type="password" name="pass"></p>
        <input type="submit" name="login" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>

</body>
</html>


