<?php
include 'db.php'; // Include the database connection file

$stmt = $pdo->query('SELECT * FROM products');

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // You can access the product data using $row['column_name']
//     echo "Product Name: " . $row['name'] . " Price: $" . $row['price'] . " Description: " . $row['description'] . "<br>";
// }
echo "<pre>";
var_dump($row);
echo "</pre>";
}

?>