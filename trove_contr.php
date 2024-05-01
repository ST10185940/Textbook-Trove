<?php
        declare(strict_types=1);
        include ('DBConn.php');
       

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        
    
        try{
                   
            $errors = [];

            if(!isset($_SESSION["user_id"])){
                $errors["user_exists"] = "You need to login first.";
            }else{
                $username = $_SESSION["username"];
                $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                $author = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
                $edition = filter_var($_POST['edition'], FILTER_SANITIZE_NUMBER_INT);
                $condition = filter_var($_POST['condition'], FILTER_SANITIZE_STRING);
                $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                $isbn = filter_var($_POST['isbn'], FILTER_SANITIZE_STRING);
                $release = filter_var($_POST['release'], FILTER_SANITIZE_NUMBER_INT);
                $publisher = filter_var($_POST['publisher'], FILTER_SANITIZE_STRING);
                $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
            }

           if(!is_integer($edition)){
                $errors["valid_edition"] = "Enter a valid edition number e.g. 12";
            }

        
            if(!is_integer($release)){
                $errors["valid_release"] = "Enter a valid release year e.g 2018";
            }

            if(!is_numeric($price)){
                $errors["valid_price"] = "Enter a valid price , please be reasonable here! ";
            }

            if($errors){
                $_SESSION["input_errors"] = $errors;  
                header("Location: your_trove.php");
                die();
            }else{
                $success = "Book has now been put on pending books list";
                $_SESSION["book_pending"] = $success;
                add_book($pdo, $title, $author, $edition, $condition, $description, $isbn, $release, $publisher, $price, $username);
                header("Location: your_trove.php");
                die();
            }


        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

    }else{
        header("Location: your_trove.php");
        die();
    }

    function add_book(object $pdo ,  string $title, string $author, int $edition, string $condition, string $description, string $isbn,  int $release,  string $publisher, float $price, string $username){
        
                $add_book = "INSERT INTO book (title,  author, `edition` ,  condition , isbn , release_year, `description` ,  available , publisher, price , seller)
                VALUES ( :title,  :author,  :`edition` ,:condition , :isbn , :`year`, :`description` ,'No',  :publisher, :price, :seller );";

                $stmt = $pdo->prepare($add_book);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':author', $author);
                $stmt->bindParam(':edition', $edition);
                $stmt->bindParam(':condition', $condition);
                $stmt->bindParam(':isbn', $isbn);
                $stmt->bindParam(':year', $release);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':publisher', $publisher);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':seller', $username);

                $stmt->execute();

    }

?>