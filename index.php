<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 2018-08-15
 * Time: 12:08 PM
 */
require_once('pdo.php');
session_start();
?>
<html>
<head></head>
<body>
<h1>Welcome to the Automobile Database</h1>
<?php
if (isset($_SESSION['name'])) {
    // User logged in
    if (isset($_SESSION['success'])) {
        echo($_SESSION['success']);
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['fail'])) {
        echo ($_SESSION['fail']);
        unset($_SESSION['fail']);
    }
    $stmt1 = $pdo->query("SELECT * FROM autos");
    if ($stmt1->rowCount() === 0) {
        echo("<p>No rows found.</p>");
        echo ('<p><a href="add.php">Add New Car</a></p>');
    }
    else {
        $stmt2 = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
        echo("<table border='1'>");
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo('<tr><td>');
            echo(htmlentities($row['make']));
            echo('</td><td>');
            echo(htmlentities($row['model']));
            echo('</td><td>');
            echo(htmlentities($row['year']));
            echo('</td><td>');
            echo(htmlentities($row['mileage']));
            echo('</td><td>');
            echo('<button><a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a></button>');
            echo('<button><a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a></button>');
        }
        echo("</table>");
    }
    echo ("<p><a href='add.php'>Add New Car</a></p>");
    echo ('<p></p><button><a href="logout.php">Logout</a></button></p>');
}
else {
    // User not logged in
    echo ("<p><a href='login.php'>Please Login</a></p>");
    echo ("<p>Try going to <a href=\"add.php\">add.php</a> without logging in, and an error should be thrown.</p>");
    echo ("<p>Try going to <a href=\"edit.php\">edit.php</a> without logging in, and an error should be thrown.</p>");
    echo ("<p>Try going to <a href=\"delete.php\">delete.php</a> without logging in, and an error should be thrown.</p>");
}
?>
</body>
</html>
