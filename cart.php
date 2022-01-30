<?php 
    /* startar sessionen */
    session_start();

    /* importerar php-filer */
    require_once("php/CreateDb.php");
    require_once("php/component.php");

    /* skapar ny instans */
    $db = new CreateDb("Productdb", "Producttb");

    /* Tar bort produkt ur varukorg när man klickar på knappen "ta bort" */
    if(isset($_POST['remove'])){
        if($_GET['action'] == 'remove'){
            foreach($_SESSION['cart'] as $key => $value){
                if($value['product_id'] == $_GET['id']){
                    unset($_SESSION['cart'][$key]);
                }
            }
        }
    };

    /* beställningsformuläret */

    $message_sent = false; 
    if(isset($_POST['email']) && $_POST['email'] != '') { // Kontrollerar så att e-post är ifyllt innan vi lagrar data från formuläret till variabler och skickar iväg beställningen. 


        
        /* Lagrar inputfälten i olika variabler */
        $userEmail = $_POST['email'];
        $userName = $_POST['name'];
        $userAddress = $_POST['address'];
        $userZip = $_POST['zip'];
        
        
        $to = "emastr900213@student.jenseneducation.se"; // email jag vill skicka meddelandena till
        $subject = "Beställning - Emanuel's Webshop"; // beställningens ämne
        $body = "Dina köp: " . "<br>";                               // beställningens body
        
        // Lägger till bställda varor i body
        if (isset($_SESSION['cart'])){
            $product_id = array_column($_SESSION['cart'], 'product_id');

            /* Lagrar databasens pordukter i "result" */
            $result = $db->getData();
            /* Loopar ut varorna från varukorgen och lägger till dem i $body */
            while($row = mysqli_fetch_assoc($result)) {
                foreach($product_id as $id){
                    if($row['id'] == $id) {
                        $body .=  $row['product_name'] .": ". $row['product_price'] . " kr<br>";
                    }

                }

            }
            
            print_r($row);
            
        }
       
        /* Köparinformation */
        $body .= "<br>Beställare: ".$userName. "<br>";
        $body .= "E-post: ".$userEmail. "<br>";
        $body .= "Adress: ".$userAddress. "<br>";
        $body .= "Postnummer och ort: ".$userZip . "<br>";

        /* Säljarinformation */
        $body .= "<br>Detta är ett skolprojekt av Emanuel Ström. Inga varor går att köpa på riktigt! Tack för att du besökte min hemsida!";


        mail($to, $subject, $body);
        

        $message_sent = true; 
    }



?>

<!DOCTYPE html>
<html lang="en">
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
    <title>Varukorg</title>

</head>
<body class="bg-light">
    <?php 
    require_once('php/header.php');
    ?>
    
    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-md-7 pt-3">
                <div>
                    <h6>Min Varukorg</h6>
                    <hr>
                    <!-- Kallar cartElement från component.php -->
                    <?php 
                    $total = 0; /* Totala priset för varukorgen */
                    if (isset($_SESSION['cart'])){
                        $product_id = array_column($_SESSION['cart'], 'product_id');

                        /* Lagrar databasens pordukter i "result" */
                        $result = $db->getData();
                        /* Loopar ut valda produkter från databasen */
                        while($row = mysqli_fetch_assoc($result)){
                            foreach($product_id as $id){
                                if($row['id'] == $id){
                                    cartElement($row['product_image'], $row['product_name'], $row['product_price'], $row['id']);
                                    $total = $total + (int)$row['product_price']; /* lägger till priset på alla valda varor och formaterar värdet till int. */
                                }
                            }
                        }
                    }else{
                        echo '<h5>Inga produkter i varukorgen</h5>';
                    }


                    ?>

                    
                </div>
            </div>

            <!-- Prisinfomation -->
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>Prisinformation</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php 
                            if(isset($_SESSION['cart'])){
                                $count = count($_SESSION['cart']); /* visar hur många varor som ligger i varukorgen */
                                echo "<h6>Pris: ($count varor)</h6>";
                            }else{
                                echo "<h6>Pris: (0 varor)</h6>"; /* om inga varor, visas 0 */
                            }
                        ?>
                        <h6>Frakt: </h6>
                        <hr>
                        <h6>Total kostnad: </h6>
                    </div>
                    <div class="col-md-6">
                        <h6><?php echo $total ?> kr</h6> <!-- visar totala priset för varukorgen -->
                        <h6 class="text-success">GRATIS</h6>
                        <hr>
                        <h6><?php echo $total ?> kr</h6>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
            <hr>
            <!-- Beställningsformulär -->

            <?php 
            if($message_sent): // kollar om beställningen är skickad eller inte för att visa ett meddelande eller ett beställningsformulär. 
            ?>

            <h3>Tack för din beställning!</h3>

            <?php 
            else:
            ?>

            <form action="cart.php" method="POST" >
                <div class="form-group">
                    <label for="email">E-post:</label>
                    <input type="email" class="form-control" name="email" placeholder="Skriv din e-postadress" required>
                </div>
                <div class="form-group">
                    <label for="name">Namn:</label>
                    <input type="text" name="name" class="form-control"  placeholder="För- och efternamn" required>
                </div>
                <div class="form-group">
                    <label for="name">Adress:</label>
                    <input type="text" name="address" class="form-control"  placeholder="Skriv din adress" required>
                </div>
                <div class="form-group">
                    <label for="name">Postnummer och ort:</label>
                    <input type="text" name="zip"  class="form-control"  placeholder="Skriv ditt postnummer och ort" required>
                </div>
                <button type="submit" name="order" class="btn btn-primary my-3">Beställ</button>
                </form>

                <?php 
                endif;
                ?>

            </div>   
        </div>
    </div>

    <!-- importing bootstrap JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>