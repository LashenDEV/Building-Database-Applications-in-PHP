<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("ACCESS DENIED");
}


if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

if (isset($_POST['add'])) {
    if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    } else {
        if (!is_numeric($_POST['year'])) {
            $_SESSION['error'] = "Year must be an integer";
            header("Location: add.php");
            return;
        }
        if (!is_numeric($_POST['mileage'])) {
            $_SESSION['error'] = "Mileage must be an integer";
            header("Location: add.php");
            return;
        } else {
            require_once 'pdo.php';
            $sql = 'INSERT INTO autos_tbl(make, model, year, mileage) VALUES(:make, :model, :year, :mileage)';

            $statement = $conn->prepare($sql);

            $statement->execute([
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'],
            ]);

            $_SESSION['success'] = "Record added";
            header("Location: index.php");
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
    <h2>Tracking Automobiles for <?= $_SESSION['user'] ?></h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <input type="hidden" name="user_id">
        Make: <input type="text" name="make"><br/><br/>
        Model: <input type="text" name="model"><br/><br/>
        Year: <input type="text" name="year"><br/><br/>
        Mileage: <input type="text" name="mileage"><br/><br/>
        <input type="submit" name="add" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>

</body>
</html>

