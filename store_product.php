<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /** array variable to hold errors */
    $errors = [];

    $product_name   = $_POST['product_name'];
    $product_image  = $_FILES['product_image'];
    /** Add form validation */
    if (empty($product_image['name'])) {
        $errors[] = 'Product image required';
    }
    if (empty($product_name)) {
        $errors[] = 'Product name required';
    }
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
    }

    /** $_FILES will have the upload file details in PHP */
    
    // echo '<pre>';
    // print_r($_FILES['product_image']);
    // print_r(pathinfo($_FILES['product_image']['name']));
    // exit;

    /** I am using pathinfo to fetch the details of the PHP Image */
    $file_name          = $product_image['name'];
    $file_size          = $product_image['size'];
    $file_tmp           = $product_image['tmp_name'];
    $pathinfo           = pathinfo($file_name);
    $extension          = $pathinfo['extension'];
    $image_extensions   = ['jpeg', 'jpg', 'png', 'svg', 'webp'];

    /** File strict validations */
    
    /** File exists */
    if(!file_exists($file_tmp)){
        $errors[] = 'File your trying to upload not exists';
    }

    /** Check if the was uploaded only */
    if(!is_uploaded_file($file_tmp)){
        $errors[] = 'File not uploaded properly';
    }

    /** Check for the image size 1024 * 1024 is 1 MB & 1024 KB */
    if($file_size > (1024 * 1024)){
        $errors[] = 'Uploaded image is greater than 1MB';
    }

    /** Check image extensions */
    if(!in_array($extension, $image_extensions)){
        $errors[] = 'Image allowed extensions '. implode(', ', $image_extensions);
    }

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }
    /** Since I want to rename the image I need its extension
     * which will be obtained with above $phpinfo variable
     * */
    /** generate random inage name */
    $new_image_name = rand(0, 10000000).time().md5(time()).'.'.$extension;
    move_uploaded_file($file_tmp, './uploads/products/'. $new_image_name);
    
    $product = $pdo->prepare("
        INSERT INTO 
            `products` (`name`, `product_image`)
        VALUES
            (:product_name, :product_image)
    ")
    ->execute([
        ':product_name'     => $product_name,
        ':product_image'    => $new_image_name,
    ]);

    if ($product) {
        echo 'Product added successfully';
    }
}
