<?php
require_once "pdo.php";

//check whether user properly logging or not
if (isset($_GET['name'])) {
    $name = $_GET['name'];
} else {
    die("Name parameter missing");
}

if (isset($_POST['Add'])) {
    if (empty($_POST['make'])) {
        $message = '<label style="color: red">Make is required</label>';
    } elseif (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
        if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
            $sql = "INSERT INTO autos(make, year, mileage) VALUES (:make, :year, :mileage)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':make' => $_POST['make'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']
            ));
            $message = '<label style="color: green">Record inserted</label>';
        }
    } else {
        $message = '<label style="color: red">Mileage and year must be numeric</label>';
    }
}

if (isset($_POST['logout'])) {
    header('Location:index.php');
}
?>

<html>
<head>
    <title>e68cc7c1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    if (isset($name)) {
        echo '<h1>Tracking Autos for ' . $name . '</h1>';
    }
    ?>
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>

    <form method="post">
        <p>Make:
            <input type="text" name="make" size="40"></p>
        <p>Year:
            <input type="text" name="year"></p>
        <p>Mileage:
            <input type="text" name="mileage"></p>
        <input type="submit" value="Add" name="Add"/>
        <input type="submit" name="logout" value="Logout"></form>


    <h1>Automobiles</h1>
    <?php
    $stmt = $pdo->query("SELECT * FROM autos");

    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>";
        echo ($row['year']) . ' ' . '<b>' . ($row['make']) . '</b>' . '/' . ($row['mileage']);
        echo "</li>";
    }
    echo "</ul>";

    ?>
</div>

</body>
</html>