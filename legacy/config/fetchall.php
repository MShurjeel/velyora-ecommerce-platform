<!-- <?php
include 'db.php'; // Include the database connection file

$stmt = $pdo->query('SELECT * FROM products');
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    $name = htmlentities($row['name']) . '<br>';
    $description = htmlentities($row['description']) . '<br>';
    $price = floatval($row['price']) . '<br>';

    echo $name . " " . $description . " " . $price . '<br>';
}

?> -->