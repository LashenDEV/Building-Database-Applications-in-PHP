<?php
session_start();
$user = false;
if (isset($_SESSION['user'])) {
    $user = htmlentities($_SESSION['user']);
}
?>
<html>
<head>
    <title>83d53270</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>

<body>
<div class="container">
    <h2>Welcome to the Automobiles Database</h2><br>
    <?php
    if ($user !== false) {
        ?>
        <?php
        if (isset($_SESSION['success'])) {
            echo '<p style="color: green">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }

        require 'pdo.php';

        $sql = 'SELECT *
		FROM autos_tbl';

        $statement = $conn->query($sql);

        // get all publishers
        $autos = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($autos) {
            echo "<table class='table'>
                <thead>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Mileage</th>
                    <th>Action</th>
                </tr>
                </thead>";


// show the publishers
            foreach ($autos as $auto) {
                echo '<tr>';
                echo '<td>' . $auto['make'] . '</td>';
                echo '<td>' . $auto['model'] . '</td>';
                echo '<td>' . $auto['year'] . '</td>';
                echo '<td>' . $auto['mileage'] . '</td>';
                echo '<td> <a href="edit.php?autos_id=' . $auto['autos_id'] . '">Edit</a>' . ' / ' . '<a href="delete.php?autos_id=' . $auto['autos_id'] . '">Delete</a>';
                echo '</tr>';
            }
            echo "</table > ";
            ?>
            <?php
        } else {
            echo "No rows found <br>";
        } ?>

        <a href="add.php">Add New Entry</a><br>

        <a href="logout.php">Logout</a><br>

        Note: Your implementation should retain data across multiple logout/login sessions. This sample implementation
        clears all its data on logout - which you should not do in your implementation.
        <?php

    } else {
        ?>

        <a href="login.php">Please log in</a><br>

        Attempt to <a href="add.php">add data</a> without logging in
        <?php
    }
    ?>
</div>
</body>
</html>