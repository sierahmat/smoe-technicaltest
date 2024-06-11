<?php
date_default_timezone_set('Asia/Jakarta');
try {
    $thread = new PDO('mysql:host=localhost;dbname=db_rahmatdhan;charset=utf8', 'root', '');
} catch (PDOException $e) {
    echo $e->getMessage();
}