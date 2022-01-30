<?php
// skapar en komponent för produkt-kortet för att inte behöva upprepa all kod i index-filen

// produktkorten
function component($productName, $productDetails, $productPrice, $productImage, $productid){
$element = "
<div class='col-md-3 col-sm-6 my-3' >
            <form action='index.php' method='post'>
                <div class='card shadow'>
                    <div>
                        <img src='$productImage' alt='product' class='img-fluid card-img-top mt-3'>
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>$productName</h5>
                                <!-- ger produkten ett betyg -->
                        <h6>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='far fa-star'></i>
                        </h6>
                        <p class='card-text'>
                        $productDetails
                        </p>
                        <h5 class='price'>$productPrice kr</h5>
                        <!-- köp-knapp -->
                        <button type='submit' name='add' class='btn btn-primary my-3' >Lägg i kundvagn <i class='fas fa-shopping-cart'></i></button>
                        <input type='hidden' name='product_id' value='$productid' ></input>
                    </div>
                </div>
            </form>
        </div>     
        ";
    echo $element;
}


// Varukorgen 
function cartElement($productImage, $productName, $productPrice, $productId ){
    $element = "
    <form action='cart.php?action=remove&id=$productId' method='post' class='cart-items'>
                        <div class='border-0 rounded'>
                            <div class='row bg-white'>
                                <div class='col-md-3 pt-2'>
                                    <img src=$productImage alt='product' class='img-fluid'>
                                </div>
                                <div class='col-md-6'>
                                    <h5 class='pt-2'>$productName</h5>
                                    <h5 class='pt-2'>$productPrice kr</h5>
                                    <button type='submit' class='btn btn-danger my-2' name='remove'>Ta bort</button>
                                </div>
                                
                            </div>
                        </div>
                    </form>

    ";
    echo $element;
}














?>