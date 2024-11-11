<?php
include 'bootstrap/init.php';

if (isset($_GET['logout'])) {
    logOut($_GET['logout']);
    redirect('auth.php');
}


if (!isLoggedIn()) {
    /// redirect to  auth form
    header("location: " . site_url('auth.php'));
}


// Folders
$folders = getFolders();


//DELETE Request
if (isset($_GET['delete_folder']) && is_numeric($_GET['delete_folder'])) {
    $deletedCount = deleteFolder($_GET['delete_folder']);
    // echo "$deletedCount folders succesfully deleted!";
}
//////////////////////////////////////////////////////////////////////////////////////////////////

//// Tasks

$tasks = getTasks();

if (isset($_GET['delete_task']) && is_numeric($_GET['delete_task'])) {
    $deletedCount = deleteTask($_GET['delete_task']);
    // echo "$deletedCount folders succesfully deleted!";
}


/// logout


include BASE_PATH . 'tpl/tpl-index.php';

use Hekmatinasser\Verta\Verta;

