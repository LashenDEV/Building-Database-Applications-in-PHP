<?php
session_start();
if (!isset($_SESSION['name'])) {
    die("Not logged in");
}

if (isset($_POST['Add'])) {
    if (!empty($_POST['make']) && !empty($_POST['year']) && !empty($_POST['mileage'])) {
        $make = htmlentities($_POST['make']);
        $year = htmlentities($_POST['year']);
        $mileage = htmlentities($_POST['mileage']);
        if (is_numeric($year) && is_numeric($mileage)) {
            include_once('pdo.php');
            $sql = "INSERT INTO autos (make, year, mileage)
VALUES (:make, :year, :mileage)";
            $statement = $conn->prepare($sql);
            $statement->execute([
                ':make' => $make,
                ':year' => $year,
                ':mileage' => $mileage
            ]);
            $_SESSION['status'] = "Record inserted";
            header("Location: view.php");
            return;
        } else {
            $_SESSION['message'] = "Mileage and year must be numeric";
            header("Location: add.php");
            return;
        }
    } else {
        $_SESSION['message'] = "Make is required";
        header("Location: add.php");
        return;
    }
}


if(isset($_POST['cancel'])){
    header("Location: view.php");
    return;
}
?>

<html>
<head>
    <title>f59a9d18</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h3>Tracking Autos for <?php echo $_SESSION['name'] ?></h3>
    <?php if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        echo(
            '<p style="color: red;" class="col-sm-10 col-sm-offset-2">' .
            htmlentities($message) .
            "</p>\n"
        );
    } ?>
    <form method="post">
        <p>Make:
            <input type="text" name="make" size="40"></p>
        <p>Year:
            <input type="text" name="year"></p>
        <p>Mileage:
            <input type="text" name="mileage"></p>
        <input type="submit" value="Add" name="Add"/>
        <input type="submit" name="cancel" value="Cancel"></form>
</div>

</body>
</html>
