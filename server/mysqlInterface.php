<?php

function connectToDb()
{
    $servername = "mariadb";
    $username = "root";
    $password = "root";
    $database = "book";


    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection failed " . $conn->connect_error);
    }

    return $conn;
}

function setPrice() {
    $conn = connectToDb();

    $query = "explain buecher";
    $result = $conn->query($query);

    $priceFound = false;
    foreach ($result->fetch_all() as $row) {
        if ($row[0] == "price") {
            $priceFound = true;
        }
    }

    if (!$priceFound) {
        $query = "alter table buecher add column price int";
        $conn->query($query);
    }

    $query = "update buecher set price = CEIL((2000 + CEIL(RAND() * (12000 - 2000))) / 5) * 5";

    $conn->query($query);
}
