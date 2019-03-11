<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 2018-08-15
 * Time: 11:50 AM
 */

$pdo = new PDO("mysql:host=localhost; port=8889; dbname=misc", 'Nikolas', '123123');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $pdo;

?>

