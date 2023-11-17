<?php
echo Shell_Exec('powershell.exe -executionpolicy bypass -NoProfile -File ".\dump.ps1"');
$date = date("d-m-Y H:i:s");
setcookie("last_dump_livre", $date, [
    'expires' => strtotime('+30 days'),
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict',
]);

$arr = array(
    'date' => $date
);
echo json_encode($arr);
