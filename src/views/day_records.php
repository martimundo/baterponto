<main class="content">
    <?php
        renderTitle(
            'Registrar Ponto',
            'Mantenha o pronto sempre atualizado!',
            'icofont-wall-clock'
        );

        include(TEMPLATE_PATH . "/messages.php");
    ?>
    <div class="card">
        <div class="card-header">
            <h3><?= $today ?></h3>
            <p class="mb-0">Ponto marcado nesta data!</p>
        </div>
        <div class="card-body">
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 1: <?= $records->time1 ?? '---' ?></span>                
                <span class="record">Saída 1: <?= $records->time2 ?? '---'?></span>
            </div>
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 2: <?= $records->time3 ??'---'?></span>
                <span class="record">Saída 2: <?= $records->time4 ?? '---'?></span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="innoutController.php" class="btn btn-custon btn-md" type="submit" value="Submit" name="submit">
                <i class="icofont-check mr-1">Marcar o Ponto</i>
            </a>
        </div>
    </div>

    <form class="mt-5" action="innoutController.php" method="post">
        <div class="input-group no-border" >
            <input type="text" name="forcedTime" class="form-control" placeholder="Informe a hora para simular o batimento">
            <button clsss="btn btn-danger ml-3">
                Simular Ponto
            </button>
        </div>        
    </form>
</main>