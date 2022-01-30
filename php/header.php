<header id="header">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="index.php" class="navbar-brand">
        <h3 class="px-5">
            <i class="fab fa-earlybirds"></i> Emanuel's Webshop | Ett skolprojekt
        </h3>
    </a>
    <button class="navbar-toggler" 
    type="button" 
    data-toggle="collapse" 
    data-target="navbarNavAltMarkup"
    aria-controls="navbarNavAltMarkup"
    aria-expanded="false"
    aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarNavAltMarkup">
        <div class="mr-auto"></div>
        <div class="navbar-nav ">
            <a href="cart.php" class="nav-item nav-link active ">
                <h5 class="px-5 cart">
                    <i class="fas fa-shopping-cart "></i> Varukorg
                    <?php 
                    
                    if(isset($_SESSION['cart'])){
                        $count = count($_SESSION['cart']);
                        echo "<span id='cart_count' class='text-center text-danger'>$count</span>";
                    }else{
                        echo '<span id="cart_count" class="text-center text-danger">0</span>';
                    }

                    ?>
                </h5>
            </a>
        </div>
    </div>

</nav>
</header>