<!DOCTYPE html>
<html>
<head>
    <title>Booking seats!</title>
</head>
<body>
<h1>Welcome to the fabulous Gulbenkian</h1>
<h2>Here are the available times for your chosen production</h2>
<h3>Please select a show time to see availability</h3>
<?php

echo "<h1>" . $_POST['name'] . ' ' . $_POST['date'] . '@' . $_POST['time'] . "</h1>";

require('connect.php');
$conn = connect();
try {
    $sql = "SELECT DISTINCT Seat.RowNumber, ROUND(Zone.PriceMultiplier *" . $_POST['price'] . ", 2) AS price, Zone.Name
                FROM Seat
                JOIN Zone ON Zone.Name = Seat.Zone
                WHERE Seat.RowNumber NOT IN  
                (SELECT Booking.RowNumber FROM Booking 
                WHERE Booking.PerfTime= :time 
                AND Booking.PerfDate= :date)
                ORDER BY Seat.RowNumber;";


    $handle = $conn->prepare($sql);
    $handle->bindParam(':time', $_POST['time']);
    $handle->bindParam(':date', $_POST['date']);
    $handle->execute();
    $conn = null;

} catch (PDOException $e) {
    echo "PDOException: " . $e->getMessage();
}
$time = $_POST['time'];
$date = $_POST['date'];
$name = $_POST['name'];
echo "
    <table>
    <tr>
      <th>Seat</th>
      <th>Zone</th>
      <th>Price</th>
    </tr>";

foreach ($handle as $row) {
    $seat = $row['RowNumber'];
    $zone = $row['Name'];
    $price = $row['price'];

    echo


    "<tr><td>$seat</td>
      <td>$zone</td>
      <td>$price</td>
      <form action = 'book.php' method = 'POST'>
      <td><input type = 'checkbox' name = 'seat[]' value = $seat class = 'seats' onclick = \"getTotal(this, $price)\"'>
      <input type = 'hidden' name = 'price' value = $price class = 'prices'>
      </td></tr>";
}

echo "</table>"
    . "<input type = 'hidden' name = 'date' value = '$date'>"
    . "<input type = 'hidden' name = 'time' value = '$time'>"
    . "<input type = 'hidden' name = 'name' value = '$name'>"
    . "Email address for booking "
    . "<input type = 'text' name = 'emailid' formmethod = 'POST'>"
    . "&emsp;&emsp;"
    . "<button type = 'submit'>Book</button></form>"
    . "&emsp;&emsp;" . "<button name = 'check price' onclick = 'checkDetails()'>Check Prices</button>";


echo "<script language = 'javascript'>

        var total = 0;
        function getTotal(checkbox, price) {
          if(checkbox.checked === true) {
          total += price;
        }
      }

        function checkDetails() {
   
    alert(total);
  }
        </script>"

?>

</body>