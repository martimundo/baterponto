<?php

function requireValidSession($requireAdmin = false){

    $user = $_SESSION['user'];

    if(!isset($user)){

        header('Location: loginController.php');
        exit();
    }elseif($requireAdmin && !$user->is_admin){

        addErrorMsg('Acesso Negado');
        header('Location: day_records.php');
        exit();
    }

}