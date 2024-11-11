<?php
session_start();
include "constants.php";
include BASE_PATH ."bootstrap/config.php";
include BASE_PATH .'vendor/autoload.php';
include BASE_PATH . "libs/helpers.php";


try {
    $pdo = new PDO("mysql:host={$database_config->host};dbname={$database_config->db}", $database_config->user, $database_config->pass);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    diePage("Connection failed: " . $e->getMessage());
}

include BASE_PATH . "libs/lib-auth.php";
include BASE_PATH . "libs/lib-tasks.php";
