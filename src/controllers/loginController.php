<?php
loadModel('Login');
session_start();
$exception = null;

//validação de login com user

if(count($_POST) > 0){   
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        $_SESSION['user'] = $user;
        header("Location: day_recordsController.php");
    } catch (AppExceptions $e) {
        
        $exception = $e;
    }
    
}
loadView('login', $_POST + ['exception' =>$exception]);