<?php
include 'db.php'; // Include the database connection file

foreach ($pdo->query('SELECT * FROM products') as $row) {
    echo "Product Name: " . $row['name'] . "Price: $" . $row['price'] . "Description: " . $row['description'] . "<br>";
} 


?>