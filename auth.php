<?php
include 'bootstrap/init.php';
$home_url = site_url();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_GET['action'];
    $params = $_POST;
    if ($action === 'register') {
        $result = register($params);
        if (!$result) {
            message("Error: an error in Registration!");
        } else {
            message("Registration is Successfull. Welcome to 7Todo .<br>
            <a href='{$home_url}auth.php'>Please Login</a>
            ", 'success');
        }
    } elseif ($action === 'login') {
        $result = login($params['email'], $params['password']);

        if (!$result) {
            message("Error: email or password is Incorrect!");
        } else {
            redirect('index.php');
        }
    }

}


include 'tpl/tpl-auth.php';
