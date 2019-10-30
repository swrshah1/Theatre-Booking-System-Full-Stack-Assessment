<!DOCTYPE html>
<html>
<head>
    <title>Gulbenkian Theatre Bookings</title>
</head>
<body>
<h1>Welcome to the fabulous Gulbenkian theatre</h1>
<h2>Please see the list below for our current shows:</h2>

<?php
require('connect.php');
$conn = connect();

try {
    $sql = "SELECT * FROM Production";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $res = $handle->fetchAll();
    $conn = null;
    echo "
		<table>
			<tr>
				<th>Title</th>
				<th>Prices from...</th>
				<th>Check availability</th>
			</tr>";

    session_start();
    foreach ($res as $row) {
        $name = $row['Title'];
        $price = $row['BasicTicketPrice'];
        echo "<form action = 'perf.php' method = POST>"
            . "<tr><td>" . $row['Title'] . "</td>"
            . "<td>" . $row['BasicTicketPrice'] . "</td>"
            . "<input type = 'hidden' name = 'name' value = '$name'>"
            . "<input type = 'hidden' name = 'price' value = '$price'>"
            . "<td><button type = 'submit' name = 'Show performances' action = 'perf.php'>
			Show Performances</button></td></form><br>";
    }
    echo '</table>';
} catch (PDOException $e) {
    echo "PDOException: " . $e->getMessage();
}
?>
</body>
</html>
