<?php
session_start();
$autos_id = $_REQUEST['autos_id'];

if (!isset($_SESSION['user'])) {
    die("ACCESS DENIED");
}


require_once 'pdo.php';
if (isset($autos_id)) {
    $stmt = $conn->prepare("SELECT * FROM autos_tbl WHERE autos_id = :autos_id");
    $stmt->execute(array(":autos_id" => $autos_id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        $_SESSION['error'] = 'Bad value for id';
        header('Location: index.php');
        return;
    }
} else {
    $_SESSION['error'] = 'Missing value for id';
    header('Location: index.php');
    return;
}

if(isset($_POST['delete'])){
    require_once 'pdo.php';
    $sql = "DELETE FROM autos_tbl WHERE autos_id = :autos_id";
    $stmt= $conn->prepare($sql);
    $stmt->execute(array(":autos_id" => $autos_id));
    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;
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
    <?php

    require 'pdo.php';

    $sql = 'SELECT make 
		FROM autos_tbl WHERE autos_id = :autos_id';

    $statement = $conn->prepare($sql);
    $statement->bindParam(':autos_id', $autos_id, PDO::PARAM_INT);
    $statement->execute();
    $publisher = $statement->fetch(PDO::FETCH_ASSOC);

    if ($autos_id) {
        echo "Confirm: Deleting" . ' ' . $publisher['make'];
    }

    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <input type="submit" name="delete" value="Delete">
    </form>
</div>

</body>
</html>

