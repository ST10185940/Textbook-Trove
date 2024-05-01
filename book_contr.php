<?php
    declare (strict_types=1);
    include('DBConn.php');

    if(($_SERVER["REQUEST_METHOD"] === "POST")){
        require_once 'config_session.inc.php';
         $user_id = $_SESSION["user_id"] ?? null;
        
            if(isset($_POST["add"])){  //adds book to basket
                $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
                $price = doubleval(filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_FLOAT));
                $seller = filter_var($_POST["seller"], FILTER_SANITIZE_STRING);

                $user_id = $_SESSION["user_id"] ?? null;
        
                if(!is_null($user_id)){ 

                    add_to_user_basket($pdo,$title,$price,$user_id, $seller); 
                    if(check($pdo, $title, $seller)){ //checks if book has been added to basket already
                        $_SESSION["added_book"] = $title." has been added to your cart";
                        header("Location: books.php");
                    }                  
                }else
                {
                    header("Location: books.php");
                    die();
                }
            }else if(isset($_POST["checkout"]))  {  //checks out books in basket and clears basket reducing item quanties 
                $user_id = $_SESSION["user_id"] ?? null;
                if(!is_null($user_id)){  
                    $get = "SELECT SUM(price) AS total_price, COUNT(title) AS num_items , basket_id FROM basket WHERE user_id = :user_id";
                    $stmt = $pdo->prepare($get);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row){
                          
                        $date = date("Y-m-d");
                        $total = doubleval($row['total_price']);  
                    
                        update_order_history($pdo , $user_id, $date ,$total);  //updates order history table
                        clear_cart($pdo, $user_id);  //clears basket after checkout
                        header("Location: login.php");     //redirects to login page after checkout               
                    }else{
                        header("Location: books.php");
                        die();
                    }
                                
                }else{
                    header("Location: books.php");
                    die();
                }
                    

            }else if(isset($_POST["clear"])){

                $user_id = $_SESSION["user_id"] ?? null;
                if(!is_null($user_id)){
                    clear_cart($pdo,$user_id);
                    header("Location: basket.php");
                    die();
                }else{
                    header("Location: basket.php");
                    die();
                }

            }else if(isset($_POST["remove"])){
                $this_title = filter_var($_POST["title_in_cart"], FILTER_SANITIZE_STRING);
                remove_from_basket($pdo, $user_id, $this_title);
                header("Location: basket.php");

            }else if(isset($_POST["increase"])){
                $this_title = filter_var($_POST["title_in_cart"], FILTER_SANITIZE_STRING);
                increase_qnty($pdo, $user_id, $this_title);
                header("Location: basket.php");

            }else if(isset($_POST["decrease"])){
                $this_title = filter_var($_POST["title_in_cart"], FILTER_SANITIZE_STRING);
                decrease_qnty($pdo, $user_id, $this_title);
                header("Location: basket.php");
                
            }else if(isset($_POST["history"])){
                $user_id = $_SESSION["user_id"] ?? null;
                if(!is_null($user_id)){
                $history = get_pruchase_history($pdo, $user_id);
                 $_SESSION["history"] = $history;
                 header("Location: basket.php");
                }else{
                    header("Location: basket.php");
                    die();
                }
    }else{
        header("Location: book.php");
        die();
    }

 }


    function add_to_user_basket(object $pdo , string $title, float $price, int $id , string $seller){
        try{
            //checks if book has been added to basket already 
            $get = "SELECT title , user_id FROM basket WHERE title = :title AND user_id = :id;";
            $stmt = $pdo->prepare($get);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result){
                $add = "UPDATE basket SET quantity += 1 WHERE title = :title AND user_id = :id";
                $stmt = $pdo->prepare($add);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
            }else{ // adds book to basket if not already added

                $add = "INSERT INTO basket (title, price, user_id , seller) VALUES (:title, :price, :id ,:seller);
                        Update book SET quantity += 1 WHERE title = :title and user_id = :id";
                $stmt = $pdo->prepare($add);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':seller', $seller);
                $stmt->execute();
                
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function check(object $pdo, string $title ,string $seller){
        $check = "SELECT * FROM basket WHERE title = :title AND seller = :seller";
        $stmt = $pdo->prepare($check);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':seller', $seller);
        $stmt->execute();
        if($stmt->rowCount() > 0){
        return true;}
    }

    function update_order_history(object $pdo , int $user_id, $date, float $total){
        try{
            $update = "INSERT INTO `order` ( `date`, user_id ,total) VALUES ( :'date', :user_id, :total)";
            $stmt = $pdo->prepare($update);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':total', $total);
            $stmt->execute();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function clear_cart(object $pdo, int $user_id){
        try{
            $clear = "DELETE FROM basket WHERE user_id = :user_id";
            $stmt = $pdo->prepare($clear);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function remove_from_basket(object $pdo , int $user_id, string $title){
        try{
            $remove = "DELETE FROM basket WHERE user_id = :user_id AND title = :title";
            $stmt = $pdo->prepare($remove);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':title', $title);
            $stmt->execute();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function increase_qnty( object $pdo , int $user_id, string $title){
        try{
            $change = " UPDATE basket SET quantity = quantity + 1 WHERE title = :title AND user_id = :user_id";
            $stmt = $pdo->prepare($change);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':title', $title);
            $stmt->execute();

        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function decrease_qnty(object $pdo , int $user_id, string $title){
        try{
            $change = " UPDATE basket SET quantity = quantity - 1 WHERE title = :title AND user_id = :user_id";
            $stmt = $pdo->prepare($change);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':title', $title);
            $stmt->execute();

        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

    }

     function get_pruchase_history($pdo, $user_id){

        $get_orders = "SELECT order_id , `date` , total , SUM(total) AS total_spent  FROM `order` WHERE user_id = :user_id";
        $stmt = $pdo->prepare($get_orders);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

     }
?>


