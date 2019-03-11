<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 2018-08-22
 * Time: 12:31 PM
 */
session_start();

if (isset($_SESSION['name'])){
    unset($_SESSION['name']);
    header("Location: index.php");
    return;
}