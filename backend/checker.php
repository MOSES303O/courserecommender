<?php
 require_once'conn.php';
 $comp=new dbclass('localhost','root','&mo1se2s3@','coursematch');
   $comp->getConnection();


   $reslt = mysqli_query($this->connection, $q);
   $roww = mysqli_fetch_assoc($reslt);            
       // Retrieve the value of $amount from the row
           $rrt=$roww['accbalance']+$rr;
           $rrk=$roww['assets']-$amount;
?>




math=>c+