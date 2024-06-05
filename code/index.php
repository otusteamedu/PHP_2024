<?php
echo "Hello, Otus!!";

$user = 'root';
$pass = 'qwerty123!wq';

// we connect to example.com and port 3307
$link = mysqli_connect('mysql:3306', $user, $pass);

$result = mysqli_query($link, "SELECT * FROM hw1.helloTable");
echo '<pre>';
while ($dataTabel = $result->fetch_object()) {
    var_dump($dataTabel->text);
}
echo '</pre>';
if (!$link) {
    die('Could not connect: ' . mysqli_error());
}
echo 'Connected successfully';
mysqli_close($link);