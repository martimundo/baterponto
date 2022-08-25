<?php
//Controller Temporário

loadModel("WorkingHours");

$wk = WorkingHours::loadFromUserAndDate(4, date('Y-m-d'));

$hra = $wk->getWorkedInterval()->format('%H:%I:%S');
print_r($hra);

echo"<br>";

