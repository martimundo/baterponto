<?php

$errors = [];
$exception = null ;
//$message = null;


if (isset($_SESSION['message'])) {

    $message = $_SESSION['message'];
    unset($_SESSION['message']);
    
}elseif($exception){

    $message = [

        'type' => 'error',
        'message' => $exception->getMessage()
    ];

    if(get_class($exception) === 'ValidationException'){
        $errors = $exception->getErrors();
    }
}

$alertType = '';

if(isset($message['type']) === 'error'){

    $alertType = 'success';

}else{
    $alertType = 'danger';
}

?>

<?php if (isset($message)): ?>
    <div roler="alert" class="my-3 alert alert-<?= $alertType ?>" >
        <?= $message['message'] ?>
    </div>
<?php endif ?>