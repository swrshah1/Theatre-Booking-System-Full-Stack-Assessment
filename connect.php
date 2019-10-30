<?php
function connect(){
 $host = 'dragon.kent.ac.uk';
 $dbname = 'ss2306';
 $user = 'ss2306';
 $pwd = 'cero-du';
 try {
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($conn) {
return $conn;
} else {
echo 'Failed to connect';
}
 } catch (PDOException $e) {
echo "PDOException: ".$e->getMessage();
 }
}
?>