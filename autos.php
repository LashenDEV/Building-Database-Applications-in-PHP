<?php
require_once "pdo.php";

//check whether user properly logging or not
if (isset($_GET['name'])) {
    $message = $_GET['name'];
} else {
    die("Name parameter missing");
}

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    $sql = "INSERT INTO autos(make, year, mileage) VALUES (:make, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']
    ));
}

if (isset($_POST['logout'])) {
    header('Location:login.php');
}
?>

<html>
<head>
    <title>Lashen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <?php
    if (isset($message)) {
        echo '<h1>Tracking Autos for ' . $message . '</h1>';
    }
    ?>
    <form method="post">
        <p>Make:
            <input type="text" name="make" size="40"></p>
        <p>Year:
            <input type="text" name="year"></p>
        <p>Mileage:
            <input type="text" name="mileage"></p>
        <input type="submit" value="Add"/>
        <input type="submit" name="logout" value="Logout">
    </form>
</div>

</body>
</html>