<?php
try {
    $db = new PDO('mysql:host=localhost;port=3306;dbname=dbperso2;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
