<?php

// start session
session_start();



require_once('./php/CreateDb.php');
require_once('./php/component.php');

// Create instance of CreateDb class
$database = new CreateDb("ProductDb","ProductTb");

if(isset($_POST['add']))
    if(isset($_SESSION['cart'])){

        $item_array_id = array_column($_SESSION['cart'],'product_id');

        /* kollar om varan redan finns i varukorgen när man lägger i kundvagn */
        if(in_array($_POST['product_id'], $item_array_id)){
            echo '<script>alert("Produkten finns redan i varukorgen...");</script>'; 
        }else{

            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id']
            );
        
            $_SESSION['cart'][$count] = $item_array;
        }

    }else{

        $item_array = array(
            'product_id' => $_POST['product_id']
        );

        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
        print_r($_SESSION['cart']);
    }

 ?>

<!DOCTYPE html>
<html lang="Sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- importing bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Importing font-awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- importing css-file -->
    <link rel="stylesheet" href="style.css">
    
    <title>Emanuel's Webshop</title>
    
</head>
<body>


<!-- Importing navigation bar -->
<?php 
require_once ("php/header.php")
?>


<!-- product card holder -->
<div class="container">
    <div class="row text-center py-5">
        <?php
        // anropar component-funktionen med produktkortet
        $result = $database->getData();
        while ($row = mysqli_fetch_assoc($result)){
            component($row['product_name'], $row['product_description'], $row['product_price'], $row['product_image'], $row['id']);
        }

        ?>
    </div>
</div>

    <!-- importing bootstrap JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>