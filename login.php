<?php
require_once 'C:\wamp64\www\textbook_trove\config_session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="_css/style.css">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Textbook Trove | Login</title>
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
        <main>
            <div class="text-image">
                <div class="image" style="margin-left: 140px;">
                    <section style="font-size: 16px;">
                        <h2>Log In (Student)</h2>
                        <div class="text-image">
                             
                            <div class="image">
                                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
                                <dotlottie-player src="https://lottie.host/fc62a7ab-ef9c-4b11-b834-1efaf748f67e/LY3eGz7m5Y.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player> 
                            </div>
                            <div>
                                <!-- code by w3codegenerator.com -->
                                    <form  class="login-form" method="POST" action="login_contr.php">
                                        <br>
                                        <div class="form-group">
                                            <label>Username: </label>
                                            <input type="text" class="form-control" name="user_username" id="Username" placeholder="@Username" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label>Password : </label>
                                            <input type="password" class="form-control"  name="user_password" id="Password1" placeholder="Password" required>
                                        </div>
                                        <br>       
                                        <button type="submit" class="btn btn-primary">Log-In</button>
                                    </form>                                   
                            </div>
                        </div>
                    </section>
                </div>

                <div style="margin-left: 250px; margin-top: 45px;">
                    <section style="font-size: 16px;">
                        <h2>Log In (Librian)</h2>
                        <div class="text-image">
     
                            <div class="image">
                                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
                                <dotlottie-player src="https://lottie.host/9ec840df-e4f0-4a8e-8346-22804f4c21f4/Vv2yJ20YJZ.lottie" background="transparent" speed="1" style="width: 350px; height: 350px;" loop autoplay></dotlottie-player>  
                            </div>
                            <div>
                                <!-- code by w3codegenerator.com -->
                                    <form  class="login-form" method="POST" action="login_contr.php">   
                                        <br>         
                                        <div class="form-group">
                                            <label>Username: </label>
                                            <input type="text" name="admin_username" class="form-control" id="Username" placeholder="@Username" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label>Password : </label>
                                            <input type="password"  name="admin_password" class="form-control" id="Password1" placeholder="Password" required>
                                        </div>
                                        <br>
                                        <button type="submit" value="login" class="btn btn-primary">Log-In</button>
                                    </form>
                            </div>
                        </div>
                    </section>
                </div>

            </div>   
            <div style="margin-left: 750px;">
            <?php
                    if(isset($_SESSION["login error"])){
                    $errors = $_SESSION["login error"];
                    foreach($errors as $error){
                    echo "<p class='form_control' style ='color: red; font-family:Stoic Script,cursive;'>$error</p>";
                    } 
                    if (isset($_SESSION["register success"])){
                        echo "<p class='form_control' style ='color: green; font-family:Stoic Script,cursive;'>$success</p>";
                    }
                }                                        
             ?>
            </div>       
        </main>
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
