<h2><?= $this->text->e($task['title']) ?> (#<?= $task['id'] ?>)</h2>

<ul>
    <li>
        <?= t('Created:').' '.$this->dt->datetime($task['date_creation']) ?>
    </li>
    <?php if ($task['date_due']): ?>
    <li>
        <strong><?= t('Due date:').' '.$this->dt->datetime($task['date_due']) ?></strong>
    </li>
    <?php endif ?>
    <?php if (! empty($task['creator_username'])): ?>
    <li>
        <?= t('Created by %s', $task['creator_name'] ?: $task['creator_username']) ?>
    </li>
    <?php endif ?>
    <li>
        <strong>
        <?php if (! empty($task['assignee_username'])): ?>
            <?= t('Assigned to %s', $task['assignee_name'] ?: $task['assignee_username']) ?>
        <?php else: ?>
            <?= t('There is nobody assigned') ?>
        <?php endif ?>
        </strong>
    </li>
    <li>
        <?= t('Column on the board:') ?>
        <strong><?= $this->text->e($task['column_title']) ?></strong>
    </li>
    <li><?= t('Task position:').' '.$this->text->e($task['position']) ?></li>
    <?php if (! empty($task['category_name'])): ?>
    <li>
        <?= t('Category:') ?> <strong><?= $this->text->e($task['category_name']) ?></strong>
    </li>
    <?php endif ?>
</ul>

<?php if (! empty($task['description'])): ?>
    <h2><?= t('Description') ?></h2>
    <?= $this->text->markdown($task['description'], true) ?>
<?php endif ?>

<?= $this->render('notification/footer', array('task' => $task)) ?>


<?php

    //public $visitante;

    
        // smtpapl.correo.ice
        // puerto 25
        // ip 10.149.20.26
        // ICETEL\OperTI
        // Clave: Icetel2019
        // Buzón: OperacionesTI@ice.go.cr
       try{
        error_log("INICIANDO CORREO EXTERNO");
            //
            ini_set('SMTP','smtpapl.correo.ice');
            error_log("INIT SET");
            $to = "carlos.echc11@gmail.com";
            //$to= "cchaconc@ice.go.cr";   
            $from = "operTI@ice.go.cr";
            //
            $mensaje = "<h2><i> TAREA CREADA <i><h2>";
            //
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: ".$from."\r\n"; 
            //
            error_log("SENDING ....");
            //
            mail($to, "test", $mensaje,$headers);
            error_log("SENT");
            
        }     
        catch(Exception $e) {
            // no debe detener el proceso si no se envía el email.
            // log
            //require_once("Log.php");  
            // log::AddD('FATAL', 'Ha ocurrido un error al realizar el envío de correo', $e->getMessage());
        }
    
    

?>
