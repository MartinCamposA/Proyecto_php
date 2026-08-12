<?php

$serverName = "45.169.100.53";
$database = "gruposol_martin";
$uid = 'gruposol_martin';
$pwd = 'Y$aBQt5Z0rJlJI.26!!';

try {
    $conn = new PDO(
        "sqlsrv:server=$serverName;Database=$database;TrustServerCertificate=1",
        $uid,
        $pwd,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
    

   
} catch (PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}

