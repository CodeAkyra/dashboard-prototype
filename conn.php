<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "https://github.com/CodeAkyra/dashboard-prototype.git";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
} else {
    echo "Success!";
}
