<!DOCTYPE html>
<html>
<head>
    <title>Congratulations: booking confirmed!</title>
</head>
<body>
<h1>Please find your booking details below:</h1>
<?php

require('connect.php');
$conn = connect();
$title = $_POST['name'];
$seatarray = $_POST['seat'];
echo "We are pleased to confirm that you have booked the following seats for ".$title.": <br>";
foreach ($seatarray as $row) {
    echo "$row <br>";

    try {
        $sql = "INSERT INTO Booking (Email, PerfDate, PerfTime, RowNumber) VALUES (:emailid, :date, :time, :row);";
        $handle = $conn->prepare($sql);
        $handle->bindParam(':emailid', $_POST['emailid']);
        $handle->bindParam(':date', $_POST['date']);
        $handle->bindParam(':time', $_POST['time']);
        $handle->bindParam(':row', $row);
        $handle->execute();

    } catch (PDOException $e) {
        echo "PDOException: " . $e->getMessage();
    }

}

$conn = null;

?>

</body>