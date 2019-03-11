<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 2018-08-22
 * Time: 4:14 PM
 */
session_start();
require_once ('pdo.php');

if (!(isset($_SESSION['name']))) {
    die('ACCESS DENIED.');
}

if (isset($_SESSION['fail'])){
    echo ($_SESSION['fail']);
    unset($_SESSION['fail']);
}
else {
    $new_make = '';
    $new_model = '';
    $new_year = '';
    $new_mileage = '';

    if (isset($_POST['new_make']) && isset($_POST['new_model']) && isset($_POST['new_year']) && isset($_POST['new_mileage'])){
        $new_make = $_POST['new_make'];
        $new_model = $_POST['new_model'];
        $new_year = $_POST['new_year'];
        $new_mileage = $_POST['new_mileage'];

        if ($_POST['new_make'] === '' || $_POST['new_model'] === '' || $_POST['new_year'] === '' || $_POST['new_mileage'] === ''){
            $_SESSION['fail'] = "All entries must be filled.";
            header("Location: edit.php");
            return;
        }
        elseif (!(is_numeric($_POST['new_year']) && is_numeric($_POST['new_mileage']))){
            $_SESSION['fail'] = "Year and mileage must be numeric";
            header("Location: edit.php");
            return;
        }
        else {
            $sql = "UPDATE autos SET make = :new_make, model = :new_model, year = :new_year, mileage = :new_mileage WHERE autos_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':new_make' => $_POST['new_make'],
                'id' => $_SESSION['autos_id'],
                ':new_model' => $_POST['new_model'],
                ':new_year' => $_POST['new_year'],
                ':new_mileage' => $_POST['new_mileage']));
            $_SESSION['success'] = "Record updated.";
            header("Location: index.php");
            return;
        }
    }

    elseif (!isset($_GET['autos_id'])){
        $_SESSION['fail'] = "Auto ID was not set.";
        header("Location: index.php");
        return;
    }

    $_SESSION['autos_id'] = $_GET['autos_id'];

    $sql = "SELECT * FROM autos WHERE autos_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array('id' => $_SESSION['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false){
        $_SESSION['fail'] = "Auto does not exist.";
        header("Location: index.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Entry | Auto Database</title>
</head>
<body>
<h1>Edit entry for, <?= $_SESSION['name']?></h1>
<form method="post">
    <input type="hidden" value="<?= $_SESSION['autos_id']?>"/>
    <p>Make: <input type="text" name="new_make" value="<?= htmlentities($new_make)?>"/> </p>
    <p>Model: <input type="text" name="new_model" value="<?= htmlentities($new_model)?>"/> </p>
    <p>Year: <input type="text" name="new_year" value="<?= htmlentities($new_year)?>"/> </p>
    <p>Mileage: <input type="text" name="new_mileage" value="<?= htmlentities($new_mileage)?>"/> </p>
    <p>
        <button type="submit" value="Edit">Edit</button>
        <button type="reset" value="Cancel">Cancel</button>
    </p>
</form>
</body>
</html>
