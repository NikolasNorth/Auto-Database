<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 2018-08-15
 * Time: 12:10 PM
 */

session_start();
$user_email = '';
$initial_pw = '';

if (isset($_SESSION['fail'])){
    echo ($_SESSION['fail']);
    unset($_SESSION['fail']);
}

if (isset($_POST['user_email']) and isset($_POST['user_pw'])){
    $user_email = html_entity_decode($_POST['user_email']);
    $user_pw = html_entity_decode($_POST['user_pw']);
    $correct_pw = hash('md5','php123');
    $is_at = false;
    $is_pw = false;

    if (strpos($user_email, '@')) $is_at = true;  // Valid email check

    if (hash('md5', $user_pw) === $correct_pw) $is_pw = true;  // Correct password check

    if ($is_pw and $is_at){
        error_log("Login success ".$user_email);
        $_SESSION['success'] = "Login successful.";
        $_SESSION['name'] = $user_email;
        header("Location: index.php");
        return;
    }
    elseif ($user_email == '' or $user_pw == '') {
        error_log("Login fail");
        $_SESSION['fail'] = "Username and password required.";
        header("Location: login.php");
        return;
    }
    elseif (!$is_pw) {
        error_log("Login fail ".$user_email." ".hash('md5',$user_pw));
        $_SESSION['fail'] = "Password incorrect.";
        header("Location: login.php");
        return;
    }
    elseif (!$is_at) {
        error_log("Login fail ".$user_email." ".hash('md5',$user_pw));
        $_SESSION['fail'] = "Invalid email.";
        header("Location: login.php");
        return;
    }
    else echo ("Error: all if statements failed in isset(POST)");
}
?>

<!DOCTYPE html>
<html>
<head><title>Login | Auto Database</title></head>
<body>
<h1>Please Login</h1>
<form method="post">
    Email: <input type="text" name="user_email" value="<?php htmlentities($user_email)?>"><br>
    Password: <input type="password" name="user_pw" value="<?php htmlentities($initial_pw)?>"><br>
    <input type="submit" value="Login">
    <button><a href="index.php">Cancel</a></button>
</form>
</body>
</html>
