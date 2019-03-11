<?php
require_once('pdo.php');
session_start();
if (!(isset($_SESSION['name']))) {
    die("ACCESS DENIED.");
}
else {
    $initial_make = '';
    $initial_model = '';
    $initial_year = '';
    $initial_mileage = '';

    if (isset($_POST['new_make']) && isset($_POST['new_model']) && isset($_POST['new_year']) && isset($_POST['new_mileage'])){
        $initial_make = $_POST['new_make'];
        $initial_model = $_POST['new_model'];
        $initial_year = $_POST['new_year'];
        $initial_mileage = $_POST['new_mileage'];

        if ($_POST['new_make'] === '' || $_POST['new_model'] === '' || $_POST['new_year'] === '' || $_POST['new_mileage'] === ''){
            $_SESSION['fail'] = "All entries must be filled.";
        }
        elseif (!(is_numeric($_POST['new_year']) && is_numeric($_POST['new_mileage']))){
            $_SESSION['fail'] = "Year and mileage must be numeric";
        }
        else {
            $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:new_make, :new_model, :new_year, :new_mileage)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':new_make' => $_POST['new_make'],
                'new_model' => $_POST['new_model'],
                'new_year' => $_POST['new_year'],
                'new_mileage' => $_POST['new_mileage']));
            $_SESSION['success'] = "Record added.";
            header("Location: index.php");
            return;
        }
        if (isset($_SESSION['fail'])){
            echo ($_SESSION['fail']);
            unset($_SESSION['fail']);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Car | Auto Database</title>
</head>
<body>
<h1>New entry for, <?= $_SESSION['name']?></h1>
<form method="post">
    <p>Make: <input type="text" name="new_make" value="<?= htmlentities($initial_make)?>"/></p>
    <p>Model: <input type="text" name="new_model" value="<?= htmlentities($initial_model)?>"/></p>
    <p>Year: <input type="text" name="new_year" value="<?= htmlentities($initial_year)?>"/></p>
    <p>Mileage: <input type="text" name="new_mileage" value="<?= htmlentities($initial_mileage)?>"/></p>
    <p>
        <input type="submit" value="Add"/>
        <input type="reset" value="Clear"/>
        <button><a href="index.php">Cancel</a></button>
    </p>
</form>
</body>
</html>
