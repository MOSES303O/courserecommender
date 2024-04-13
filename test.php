<?php
require_once'backend/conn.php';
$connection=new dbclass('localhost','root','','coursematch');
$connection->getConnection();
$sult = mysqli_query($comp->getConnection(), "SELECT*FROM universitylist");
   if ($sult && mysqli_num_rows($sult) > 0) {
    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($sult);

    // Free the result set after fetching the row
    mysqli_free_result($sult);

    // Access the elements of the $row array safely
    echo $row;
}
?>