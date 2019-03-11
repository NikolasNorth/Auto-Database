<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 2018-08-21
 * Time: 10:43 AM
 */
require_once('pdo.php');
session_start();

if (!isset($_SESSION['name'])) {
    echo ('<p>Session timed out.</p>');
    echo ("<p><a href='login.php'>Return to login page</a></p>");
    die();
}
else {
    if (isset($_POST['autos_id']) and isset($_POST['delete'])){
        $sql1 = "DELETE FROM autos WHERE autos_id = :id1";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute(array(':id1' => $_POST['autos_id']));
        $_SESSION['success'] = "Record deleted.";
        header("Location: index.php");
        return;

    }
    elseif (!isset($_GET['autos_id'])){
        // GET variable not set
        $_SESSION['fail'] = "Error: Missing auto id";
        header("Location: index.php");
        return;
    }

    // Check to see if autos_id is valid
    $sql2 = "SELECT * FROM autos WHERE (autos_id = :id2)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array(':id2' => $_GET['autos_id']));
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($row === false){
        $_SESSION['fail'] = "Error: Vehicle not found.";
        header("Location: index.php");
        return;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirming Delete | Auto Database</title>
</head>
<body>
<h1>Are you sure you want to delete, <?= $_GET['autos_id']?>?</h1>
<form method="post">
    <input type="hidden" name="autos_id" value="<?= $_GET['autos_id'] ?>"/>
    <input type="submit" name="delete" value="Delete"/>
    <button><a href="index.php">Cancel</a></button>
</form>
</body>
</html>
