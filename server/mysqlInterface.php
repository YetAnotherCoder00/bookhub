<?php

session_start();


function connectToDb(): mysqli
{
    $servername = "mariadb";
    $username = "root";
    $password = "root";
    $database = "book";


    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error)
    {
        die("connection failed " . $conn->connect_error);
    }

    return $conn;
}

function setPrice(): void
{
    $conn = connectToDb();

    $query = "explain buecher";
    $result = $conn->query($query);

    $priceFound = false;
    foreach ($result->fetch_all() as $row)
    {
        if ($row[0] == "price") {
            $priceFound = true;
        }
    }

    if (!$priceFound)
    {
        $query = "alter table buecher add column price int";
        $conn->query($query);
    }

    $query = "update buecher set price = CEIL((2000 + CEIL(RAND() * (12000 - 2000))) / 5) * 5";

    $conn->query($query);
}

function getCount($search, $filter, $filterType): int
{
    $booksPerPage = 18;
    $conn = connectToDb();

    $query = "SELECT COUNT(distinct buecher.id) FROM book.buecher, book.kategorien 
        WHERE kurztitle LIKE ?";

    if (isset($filter) && $filter != "")
    {
        switch ($filterType) {
            case '1':
                $query .= " AND kategorien.kategorie = ? AND buecher.kategorie = kategorien.id";
                break;
            case '2':
                $query .= " AND buecher.verkauft = ?";
                break;
            case '3':
                $query .= " AND buecher.zustand = ?";
                break;
            default:
                break;
        }
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $search, $filter);
    }
    else {
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $search);
    }
    $stmt->execute();

    $result = $stmt->get_result()->fetch_row();

    return ceil($result[0] / $booksPerPage);
}

function getResult(string $search, string $sortBy, int $pageNumber, string $filter, string $filterType): array
{
  $booksPerPage = 18;
  $conn = connectToDb();

  $query = sprintf("SELECT distinct buecher.id, kurztitle, buecher.price FROM book.buecher, book.kategorien
        WHERE kurztitle LIKE '%%%s%%'", $search);

  if ($filter != "")
  {
    switch ($filterType)
    {
      case '1':
        $query .= sprintf(" AND kategorien.kategorie = '%s' AND buecher.kategorie = kategorien.id", $filter);
        break;
      case '2':
        $query .= sprintf(" AND buecher.verkauft = '%s'", $filter);
        break;
      case '3':
        $query .= sprintf(" AND buecher.zustand = '%s'", $filter);
        break;
      default:
        break;
    }
  }
  $query .= sprintf(" ORDER BY %s LIMIT %d, %d", $sortBy, $pageNumber * $booksPerPage, $booksPerPage);

  $result = $conn->query($query);
  return $result->fetch_all();
}
