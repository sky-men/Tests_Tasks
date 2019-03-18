<?php
$mysqli = new mysqli('localhost', 'username', 'password', 'dbname');

function query ($query)
{
    global $mysqli;

    $result = $mysqli->query($query);

    return $result->fetch_all(MYSQLI_ASSOC);
}