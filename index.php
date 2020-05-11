<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Demo</title>
    <style>
        form{ width: 250px; margin: auto; }
        form input{ width: 100%; padding: 3px; }
    </style>
</head>
<body>
    <form action="store_product.php" method="post" type="multipart/form-data">
        <div>
            <label for="product_name">Product Name</label> <br>
            <input type="text" name="product_name" id="product_name">
        </div><br>
        <div>
            <label for="product_image"></label> <br>
            <input type="file" name="product_image" id="product_image">
        </div><br>
        <div>
            <input type="submit" value="Create Product">
        </div>
    </form>
</body>
</html>