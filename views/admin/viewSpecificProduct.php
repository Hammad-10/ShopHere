<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Get currencies from the class

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
</head>

<body>
    <div class="container mt-5">
        <h2>Product Form</h2>
        <form action="/ptest/ShopHere/routes.php?page=update_delete" method="post" enctype="multipart/form-data">
            <!-- Hidden input to store the sno -->
            <input type="hidden" name="sno" value="<?php echo htmlspecialchars($_SESSION['sno']); ?>">

            <!-- checking if the image is already set then don't show the choose image option -->
            <?php
            if (isset($_SESSION['image']))
                echo '<img src="' . htmlspecialchars($_SESSION['image']) . '" alt="Product Image" style="width:100px;height:100px;">';
        
            ?>

            <!-- SKU field -->
            <div class="form-group">
                <label for="sku">SKU:</label>
                <input type="text" id="sku" name="sku" class="form-control" value="<?php echo htmlspecialchars($_SESSION['sku']); ?>">
            </div>

            <!-- Name field -->
            <div class="form-group">
                <label for="productname">Name:</label>
                <input type="text" id="productname" name="productname" class="form-control" value="<?php echo htmlspecialchars($_SESSION['name']); ?>">
            </div>

            <!-- Price field -->
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($_SESSION['price']); ?>">
            </div>

            <!-- Quantity field -->
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" class="form-control" value="<?php echo htmlspecialchars($_SESSION['quantity']); ?>">
            </div>

            <!-- Submit button to update the product -->
            <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>

            <!-- Submit button to delete the product -->
            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
        </form>

        <br>

       

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>