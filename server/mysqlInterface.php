<?php

function connectToDb()
{
    $servername = "172.17.0.1";
    $username = "root";
    $password = "root";
    $database = "book";


    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed " . $conn->connect_error);
    }

    return $conn;
}