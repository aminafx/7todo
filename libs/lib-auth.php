<?php

function isLoggedIn()
{
   return isset($_SESSION['login']);
}

function register($request)
{
    if (isset($request['name']) && strlen($request['name']) > 3 and
        isset($request['email']) && filter_var($request['email'], FILTER_VALIDATE_EMAIL) and
        isset($request['password']) && strlen($request['password']) > 5
    ) {
        global $pdo;
        $password = password_hash($request['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (name, password,email) VALUES (:name,:password,:email); ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':name' => $request['name'], ':password' => $password, ':email' => $request['email']]);
        redirect('auth.php');
    } else {
        echo 'request is invalid';
    }
}

function getUserByEmail($email)
{
    global $pdo;
    $sql = "SELECT * FROM `users` WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records[0] ?? null;


}


function logOut($id){
    unset($_SESSION['login']);
}

function login($email,$password)
{

    $user = getUserByEmail($email);
    if(is_null($user)){

        return false;
    }
    if(password_verify($password,$user->password)){
        /// login is successfully
        $_SESSION['login'] = $user;
        return true;

    }
}