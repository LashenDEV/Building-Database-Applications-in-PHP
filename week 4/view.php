<?php
session_start();
if (!isset($_SESSION['name'])) {
    die('Not logged in');
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
    <h2>Tracking Autos for <?php echo $_SESSION['name'] ?></h2>
    <?php
    if (isset($_SESSION['status'])) {
        $status = htmlentities($_SESSION['status']);
        unset($_SESSION['status']);
        echo(
            '<p style="color: green;" class="col-sm-10 col-sm-offset-2">' .
            htmlentities($status) .
            "</p>\n"
        );
    }
    ?>
    <h2>Automobiles</h2>
    <?php
    include_once('pdo.php');
    $stmt = $conn->prepare(
        "SELECT * FROM autos");
    $stmt->execute();
    $autos = $stmt->fetchAll();
    foreach ($autos

             as $auto) {
        ?>
        <li><b><?php echo $auto['year'], ' ', $auto['make'], ' / ', $auto['mileage'];
                ?></b></li>
    <?php } ?>
    <p><a href="add.php">Add New</a> | <a href="logout.php">Logout</a></p>
</div>

</body>
</html>