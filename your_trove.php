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
                <img  class="logo" src="_images/textbook_trove_logo.png" alt="Textbook Trove primary Logo"  align="left" hspace="50">
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
                        <li><a href="index.html">Home </a></li>
                        <li><a href="books.php">Books </a></li>
                        <li><a href="notice.html">Notice Board </a></li>
                        <li><a href="your_trove.php">Your Trove </a></li>
                        <li><a href="contact.html">Contact Us </a></li>
                    </ul>
                </nav>
    </header>
    <hr style="margin-left: 100px; margin-right: 100px;">
    <br>
    <section>
        <main class="buy-sell">
            <h2>Book Listing</h2>
            <br>
            <p>Fill in the form below to apply to sell a book and wait for it to be listed </p>
            <br>
            <div class="text-image">
                <div>
                    <form method="POST" action="trove_contr.php" style="max-width:150%" enctype="multipart/form-data">
                        <div class="form-group">
                           <input type="text" name="title" class="form-control" id="title" placeholder="Book title" required>
                        </div>
                        <br>
                        <div class="form-group">
                           <input type="text" name="author" class="form-control"  placeholder="Book author" required>
                        </div>
                        <br>
                        <div class="form-group">
                           <input type="text" name="edition" class="form-control" id="edition" placeholder="Book edition" required>
                        </div>
                        <br>
                        <div class="form-group">
                           <!--drop dropdown menu for condition-->
                            <select name="condition" id="condition" class="form-control" required>
                                 <option value="Like_New">Like_New</option>
                                 <option value="Worn">Worn</option>
                                <option value="Damaged">Dying Slowly</option>
                            <br>
                        </div>
                        <br>
                        <div class="form-group">
                           <input type="text" name="isbn" class="form-control" placeholder="ISBN" required>
                        </div>
                        <br>
                        <div class="form-group">
                           <input type="text" name="release" class="form-control"  placeholder="Release Year" required>
                        </div>
                        <br>
                        <div>
                            <input type="text" name="description" class="form-control" placeholder=" book description" required>
                        </div>
                        <br>
                        <div class="form-group">
                           <input type="text" name="publisher" class="form-control"  placeholder="Publisher" required>
                        </div>
                        <br>
                        <div class="form-group">
                           <input type="text" name="price" class="form-control" id="title" placeholder="Asking Price e.g. R350" required>
                        </div>
                        <br>
                        <!--div class="form-group">
                           <label> Provide an image of the book</label>
                           <input type="file"  id="image" name="image" accept="image/*"  class="form-control" id="img" >
                        </div-->
                        <br>
                        <button type="submit" name="request" class="btn btn-success">Request Book Listing</button>
                    </form>
                </div>
                
                <div style="margin-left:400px; margin-top:-400px;">
                    <h3>Your Listings</h3>
                    <br>
                    <p>Books you have currently listed for sale will appear here</p>
                    <br>
                    <table class=" table table-hover">
                            <thead>
                                <tr>
                                    <th>Title.&nbsp; &nbsp;</th>
                                    <th>Seller (You)</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <!-- PHP code to fetch and display database records -->
                                <?php
                                require_once 'DBConn.php';
                                $username = $_SESSION["username"] ?? null;
                                $query = "SELECT title, seller, price FROM book WHERE seller = :user AND available = 'Yes' LIMIT 4;";
                                $stmt = $pdo->prepare($query);
                                $stmt->bindParam(':user', $username);
                                $stmt->execute(); 
                                         

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['seller']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                                    echo "</tr>";
                                }       
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <div>
                            <h4>Note:</h4>
                            <br>
                            <?php
                                                                
                                if(isset($_SESSION["input_errors"])){
                                    $errors = $_SESSION["input_errors"];
                                    foreach($errors as $error){
                                    echo '<p style ="color: red; font-family:Stoic Script,cursive;">' . $error . '</p>';
                                    }
                                }else if(isset($_SESSION["book_pending"])){
                                    $success = $_SESSION["book_pending"];
                                    echo '<p style ="color: green; font-family:Stoic Script,cursive;">' . $success .'</p>';
                                }
                                                
                            ?>

                        </div>                       
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