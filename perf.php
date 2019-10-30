<!DOCTYPE html>
<html>
<head>
    <title>Performance details</title>
</head>
<body>
<h1>Welcome to the fabulous Gulbenkian</h1>
<h2>Here are the available performances for your chosen production</h2>
<h3>Please select any performance to see availability</h3>
<?php

echo "<h1>" . $_POST['name'] . "</h1>";

require('connect.php');
$conn = connect();

try {
    $sql = "SELECT * FROM Performance WHERE Performance.Title = :name;";

    $handle = $conn->prepare($sql);
    $handle->execute(array(":name" => $_POST['name']));

    $conn = null;
    $res = $handle->fetchAll();

    echo "
    <table>
    <tr>
      <th>Date</th>
      <th>Time</th>
      <th>Title</th>
    </tr>";
    $price = $_POST['price'];
    foreach ($res as $row) {
        $date = $row['PerfDate'];
        $time = $row['PerfTime'];
        $name = $row['Title'];
        echo "<form action = 'seats.php' method = 'POST' >"
            . "<tr><td>" . $row['PerfDate'] . "</td>"
            . "<td>" . $row['PerfTime'] . "</td>"
            . "<td>" . $row['Title'] . "</td>"
            . "<input type='hidden' name='date' value='$date'>"
            . "<input type='hidden' name='time' value='$time'>"
            . "<input type='hidden' name='name' value='$name'>"
            . "<input type='hidden' name = 'price' value = '$price'>"
            . "<td><button type='submit' name='button'>
      Show availability</button></td></tr></form>";
    }
    echo "</table>";

    //var_dump($res);

    //echo "<br/>";

    //}

} catch (PDOException $e) {
    echo "PDOException: " . $e->getMessage();
}
?>
</body>