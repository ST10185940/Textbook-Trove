<?php
require_once 'C:\wamp64\www\textbook_trove\config_session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="_css\style.css"> 
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Textbook Trove | Home</title>
</head>
<body>
    <header>
            <div style=" margin-top: 40px;">
            <a href="index.html"><img  class="logo" src="_images/textbook_trove_logo.png" alt="Textbook Trove primary Logo"  align="left" hspace="50"></a> 
                <br>
                <nav>                 
                        <ul>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Account 
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
                                    <a class="dropdown-item" href="register.php">Register</a>
                                    <a class="dropdown-item" href="login.php">Log-In</a>                            
                                </div>
                            <li><a class="nav-link" href="basket.php">Basket <img src="_images/Basket_alt_duotone_line.png" height="31px" alt=""></a></li>
                            <li><a class="nav-link" href="bookmarks.html">Bookmarks <img src="_images/Bookmark_light.png" height="25px" alt=""></a></li>          
                        </ul>                                  
                </nav>
            </div>
            <br>
            <div style="margin-top: auto;">
                <nav class="secondary-nav">
                    <ul>
                        <li><a href="index.html">Home <img src="_images/Home_light.png" height="25px"></a></li>
                        <li><a href="books.php">Books <img src="_images/Book.png" alt=""></a></li>
                        <li><a href="notice.html">Notice Board <img src="_images/Message.png" height="30px"></a></li>
                        <li><a href="your_trove.php">Your Trove <img src="_images/Mortarboard_light.png" alt=""></a></li>
                        <li><a href="contact.html">Contact Us <img src="_images/Vector.png" alt=""></a></li>
                    </ul>
                </nav>
    </header>
    <hr style="margin-left: 100px; margin-right: 100px;">
    <br>
    <section>        
        <br>
        <br>
        <main class="about" style="margin-top:50px; margin-left:140px;">
        <h2>Your Items</h2>       
        <br>
        <div class="text-image">

                <div>
                    <?php
                                require_once 'DBConn.php';
                                $user_id = $_SESSION["user_id"] ?? null;
                                $get = "SELECT title, price, seller, quantity FROM basket WHERE user_id = :user_id";
                                $stmt = $pdo->prepare($get);
                                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                if(!$row){
                                    echo
                                        '<div style="margin-top: -150px;" class="alert alert-danger" role="alert">'.
                                            'Your basket is empty. Continue <a href="books.php">shopping</a>'.
                                        '</div>
                                         <br> ';

                                }else{
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        echo
                                            
                                            '<p>'. $row['title']. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' from: '. $row['seller']. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. 'R'. $row['price'] .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. 'QTY: '  .$row['quantity']  .'</p>'.
                                            '<form  class="login-form" method="POST" action="book_contr.php">   
                                                    <input type="hidden" name="title_in_cart" value="'. $row['title'] .'">             
                                                    <button name="remove" type= "submit" class="btn btn-danger">&times;</button>
                                                    <button name"increase" type="submit" class="btn btn-info">&plus;</button>
                                                    <button name="decrease" type="submit" class="btn btn-info">&minus;</button>
                                            </form>'.
                                            '<br>';
                                        
                        
                                    }
                            }
                        
                        ?>
                </div>
                <div class="vr"></div>  <!--vertical line -->
                <div style="margin-left:50px;  font-family: 'Stoic Script', cursive;" >
                    <?php
                        require_once 'DBConn.php';
                        $user_id = $_SESSION["user_id"] ?? null;
                        $get = "SELECT SUM(price) AS total_price, COUNT(title)  AS num_items , basket_id FROM basket WHERE user_id = :user_id";
                        $stmt = $pdo->prepare($get);
                        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        echo '
                            <form  class="login-form" method="POST" action="book_contr.php">                
                                <button name="clear" type= "submit" class="btn btn-danger">Clear Basket</button>
                            </form>
                            <br>
                            <br>
                            <h5>Order Summary</h5>
                            <br>
                            <p>Order Num: '  .$row['basket_id']   .'</p>
                            <br>'.
                            '<p>Items: ' .$row['num_items']. '</p>
                            <br>
                            <p>Total: ' .$row['total_price']. '</p>                        
                            <br>
                            <br>
                            <br>
                            <form  class="login-form" method="POST" action="book_contr.php">                
                                <button name="checkout" type= "submit" class="btn btn-success">Checkout</button>
                            </form>    
                            <br>                    
                            <form method="POST" action="book_contr.php">
                                <button  name="history" type="button" class="btn btn-info">
                                 Purchase History
                                </button>
                            </form>
                        ';                     
                     ?>   
                            <div >
                            <?php
                              $user_id = $_SESSION["user_id"] ?? null;
                                if (isset($_SESSION["history"]) && !is_null($user_id)){
                                    $row = $_SESSION["history"];
                                    while($row){
                                        echo
                                            '<div>'.
                                                '<p>Order Ref: '.  $row["order_id"].  '   Date: '. $row["date"].  '   Total: '. $row["total"] .'</p>'.
                                            '</div>';
                                    }                                      
                                                                     
                                }                  
                                ?>
                            </div> 
                </div>

        </main>
       
    </section>

    <footer> 
        <hr style="margin-left: 100px; margin-right: 100px;">
        <br>
            <nav class="footer-nav">
                <ul>
                    <li><a href="index.html">Home </a></li>
                    <li><a href="books.php">Books </a></li>
                    <li><a href="notice.html">Notice Board </a></li>
                    <li><a href="your_trove.php">Your Trove </a></li>
                    <li><a href="contact.html">Contact Us </a></li>             
                </ul>
            </nav>   

            <div class="social">
                <img src="_images/_facebook_.png" alt="facebook link">
                <img src="_images/_twitter original_.png" alt="twitter link">
                <img src="_images/_instagram_.png" alt="instagram link">
                <img src="_images/_youtube_.png" alt="youtube link">
                <img src="_images/_telegram_.png" alt="telegram link">
                <img src="_images/_envelope lines_.png" height="25px">
                <p> email@textbooktrove.com</p>   
            </div>   
         <br>     
           <p>&copy; 2023 TextBookTrove.Com .All rights reserved. </p>     
    </footer> 
</body>
</html>