<?php

function currentUserId()
{
  $user = $_SESSION['login'];
  return $user->id;
}


/////// Folders


function getFolders()
{
    global $pdo;
    $currentUserId = currentUserId();
    $sql = "select * from folders where user_id = $currentUserId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records;
}

function addFolders($folder_name)
{
    global $pdo;
    $currentUserId = currentUserId();
    $sql = "INSERT INTO `folders` (name, user_id) VALUES (:folder_name,:user_id); ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':folder_name' => $folder_name, ':user_id' => $currentUserId]);
    return $stmt->rowCount();
}

function deleteFolder($folder_id)
{
    global $pdo;
    $sql = "delete from folders where id = $folder_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    redirect('index.php');
}







////////////////////////////////////////////////////////////////////

///// tasks

function getTasks()
{
    global $pdo;
    $currentUserId = currentUserId();
    $folder = $_GET['folder_id'] ?? null  ;
   if(isset($folder) && is_numeric($folder)){
       $sql = "select * from tasks where user_id = $currentUserId and folder_id = $folder;";
   }else{
       $sql = "select * from tasks where user_id = $currentUserId";
   }


    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records;
}

function deleteTask($task_id)
{
    global $pdo;
    $sql = "delete from tasks where id = $task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
   redirect('index.php');
}


function addTask($taskTitle,$folderId){
    global $pdo;
    $currentUserId = currentUserId();
    $sql = "INSERT INTO `tasks` (title, user_id,folder_id) VALUES (:task_title,:user_id,:folder_id); ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':task_title' => $taskTitle, ':user_id' => $currentUserId,':folder_id'=>$folderId]);
    return $stmt->rowCount();
}

function doneSwitch($taskId){

    global $pdo;
    $currentUserId = currentUserId();
    $sql = "update `tasks` set is_done = 1 - is_done where user_id = ?  and id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$currentUserId,$taskId]);
    return $stmt->rowCount();
}