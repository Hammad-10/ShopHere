<?php
$products = [
    ["image" => "../assets/Images/BeautyCraftsSources/1.jpg", "name" => "Hydrating Face Mist", "price" => 100],
    ["image" => "../assets/Images/BeautyCraftsSources/2.jpg", "name" => "Conatural Eye Serium", "price" => 200],
    ["image" => "../assets/Images/BeautyCraftsSources/3.jpg", "name" => "Hydrating Face Mist", "price" => 300],
    ["image" => "../assets/Images/BeautyCraftsSources/4.webp", "name" => "Conatural Eye Serium", "price" => 400],
    ["image" => "../assets/Images/BeautyCraftsSources/5.webp", "name" => "Hydrating Face Mist", "price" => 500],
    ["image" => "../assets/Images/BeautyCraftsSources/6.webp", "name" => "Conatural Eye Serium", "price" => 600],
    // Add more products as needed
];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your custom CSS file -->
    <title>Product Grid</title>
</head>
<body>
    <div class="product-grid">
        <?php
        $count = 0;
        $totalProducts = count($products);
        while ($count < $totalProducts) {
            echo '<div class="product-row">';
            for ($i = 0; $i < 3; $i++) {
                if ($count < $totalProducts) {
                    $product = $products[$count];
                    echo '<div class="product-item">';
                    echo '<img class="productImage" src="' . $product["image"] . '" alt="' . $product["name"] . '">';
                    echo '<h3>' . $product["name"] . '</h3>';
                    echo '<p>$' . $product["price"] . '</p>';
                    echo '<button class="add-to-cart" data-sku="' . $product["sku"] . '">Add to Cart</button>';
                    echo '</div>';
                    $count++;
                }
            }
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
