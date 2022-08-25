<?php
session_start();
requireValidSession();
loadModel('WorkingHours');

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

try {
    
    $currentTime = strftime('%H:%M:%S', time());
    
    if(isset($_POST['forcedTime'])){
        $currentTime = $_POST['forcedTime'];
    }
    if(isset($_POST['forcedTime'])) {
        $currentTime = $_POST['forcedTime'];
    }

    $records->innout($currentTime);
    addSuccessMsg('Ponto inserido com sucesso!');
} catch(AppExceptions $e) {

    addErrorMsg($e->getMessage());
}
header('Location: day_recordsController.php');
