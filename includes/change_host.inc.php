<?php
//......................................................
$host='localhost';
$username='root';
$password='123456';
$dbname='bookstore_db';
//.......................................................
$conn_db=new mysqli($host,$username,$password,$dbname)
or die("Connect failed: %s\n". $conn_db -> error);

?>