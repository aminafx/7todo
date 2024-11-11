<?php

include_once "../bootstrap/init.php";


if (!isset($_POST['action']) || empty($_POST['action'])) {
    diePage('Invalid Action!');
}

if (isAjaxRequest() === false) {
    diePage("Invalid Request!");
}

if ($_POST['action'] === 'addFolder') {
    if (!isset($_POST['folderName']) || strlen($_POST['folderName']) < 3) {
        echo "نام فولدر باید بزرگتر از 2 حرف باشد.";
        die();
    }

    echo addFolders($_POST['folderName']);

}

if ($_POST['action'] === 'addTask') {

    $taskTitle = $_POST['taskTitle'];

    if (!isset($_POST['folderId']) || empty($_POST['folderId'])) {

        echo "فولدر را انتخاب کنید.";
        die();
    }
    $folderId = $_POST['folderId'];

    if (!isset($taskTitle) || strlen($taskTitle) < 3) {
        echo "عنوان تسک باید بزرگتر از 2 حرف باشد.";
        die();
    }
    echo addTask($taskTitle, $folderId);
}

if ($_POST['action'] === 'doneSwitch') {

    if (!isset($_POST['action']) || is_numeric($_POST['action'])) {
        echo "تسک شما ایراد دارد";
        die();
    }

    echo doneSwitch($_POST['taskId']);

}







