<?php

    $pdo = new PDO('mysql:host=localhost;mysql:dbname=ijdb;charset=utf8',
                'root', 
                'password1234'); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $dbName = 'ijdb';
