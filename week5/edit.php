<?php
session_start();
$autos_id = $_REQUEST['autos_id'];

if (!isset($_SESSION['user'])) {
    die("ACCESS DENIED");
}

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
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


if (isset($_POST['save'])) {
    if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=" . $autos_id);
        return;
    } else {
        if (!is_numeric($_POST['year'])) {
            $_SESSION['error'] = "Year must be an integer";
            header("Location: edit.php?autos_id=" . $autos_id);
            return;
        }
        if (!is_numeric($_POST['mileage'])) {
            $_SESSION['error'] = "Mileage must be an integer";
            header("Location: edit.php?autos_id=" . $autos_id);
            return;
        } else {
            require_once 'pdo.php';
            $make = htmlentities($_POST['make']);
            $model = htmlentities($_POST['model']);
            $year = htmlentities($_POST['year']);
            $mileage = htmlentities($_POST['mileage']);

            $stmt = $conn->prepare("
	    	UPDATE autos_tbl
	    	SET make = :make, model = :model, year = :year, mileage = :mileage
		    WHERE autos_id = :autos_id
	    ");

            $stmt->execute([
                ':make' => $make,
                ':model' => $model,
                ':year' => $year,
                ':mileage' => $mileage,
                ':autos_id' => $autos_id,
            ]);
            $_SESSION['success'] = "Record edited   ";
            header("Location: index.php");
            return;
        }
    }
}

require_once 'pdo.php';
$stmt = $conn->prepare("
	    SELECT * FROM autos_tbl
	    WHERE autos_id = :autos_id
	");

$stmt->execute([
    ':autos_id' => $autos_id,
]);

$auto = $stmt->fetch(PDO::FETCH_OBJ);

?>
<html>
<head>
    <title>83d53270</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Editing Automobile</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <input type="hidden" name="user_id">
        Make: <input type="text" name="make" value="<?php echo htmlentities($auto->make); ?>"><br/><br/>
        Model: <input type="text" name="model" value="<?php echo htmlentities($auto->model); ?>"><br/><br/>
        Year: <input type="text" name="year" value="<?php echo htmlentities($auto->year); ?>"><br/><br/>
        Mileage: <input type="text" name="mileage" value="<?php echo htmlentities($auto->mileage); ?>"><br/><br/>
        <input type="submit" name="save" value="Save">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>

</body>
</html>

