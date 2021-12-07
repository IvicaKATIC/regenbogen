<?php

ini_set('error_reporting', E_ALL);
ini_set( 'display_errors', 1 );

// DB-Connection Attribute
$host = "localhost";
$dbName = "kompetenz_regenbogen";
$dbUsername = "root";
$dbPassword = "";

// DB-Connection herstellen
$connection = new PDO("mysql:dbname=$dbName; host=$host;", $dbUsername, $dbPassword);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

