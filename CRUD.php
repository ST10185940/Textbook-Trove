<?php
      declare(strict_types=1);
      include('DBConn.php');

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            try{         
                require_once 'config_session.inc.php';
                $errors = [];
    
                if(isset($_POST["verify"])){ //verify pending user on verify click on admin dashboard

                    $studentNum = filter_var($_POST["st_num"], FILTER_SANITIZE_STRING);
                    //if(empty($studentNum)){$errors[] = "Please enter the student number";}
                   // if(valid($studentNum) === false){$errors[] = "Please enter a valid student number";}
                    if(!exists($pdo,$studentNum ,"pending_user")){
                        $errors[] = "student is not on pending list  ";       
                    } 
                    if(exists($pdo,$studentNum ,"user")){
                        $errors[] = "student has been verified already ";       
                    }
                     
                    if($errors){
                        $_SESSION["st_num error"] = $errors; 
                        header("Location: dashboard.php");
                        die();
                    }else{
                        verify_account($pdo, $studentNum);
                        $success = "student has been added as a user";
                        $_SESSION["st_num success"] = $success;                                            
                        header("Location: dashboard.php");
                    }

                }else if(isset($_POST["delete"])){  //delete user on delete click on admin dashboard

                    $delete_user = filter_var($_POST["st_num"], FILTER_SANITIZE_STRING);
                   //if(empty($delete_user)){$errors[] = "Please enter the student number";}
                    //if(valid($delete_user) === false){$errors[] = "Please enter a valid student number";}
                    if(!exists($pdo,$delete_user ,"user")){$errors[] = "Student is not registered or has been removed from users";} 

                    if($errors){
                        $_SESSION["st_num error"] = $errors; 
                        header("Location: dashboard.php");
                        die();
                    }else{
                        $success = "student account has been deleted";
                        $_SESSION["st_num success"] = $success;
                        delete_user($pdo, $delete_user);
                        header("Location: dashboard.php");
                    }
                    
                }else if (isset($_POST["search"])) {  //search for user on admin dashboard
                    $search = filter_var($_POST["search_num"], FILTER_SANITIZE_STRING);
                    $user_data = find_user($pdo, $search);
                    if($user_data !==null){
                        $_SESSION["results"] = $user_data;
                        header("Location: dashboard.php");
                    }
                }                   
                else if (isset($_POST["update"])){  //update user on admin dashboard

                    $field = filter_var(strtolower($_POST["field"]), FILTER_SANITIZE_STRING);
                    $value = filter_var($_POST["new_val"], FILTER_SANITIZE_STRING);
                    $student = filter_var($_POST["st_num"], FILTER_SANITIZE_STRING);
                    
                    if (!valid_field($field)){
                             $errors[] = "Please enter a valid field , like st_num or email";
                    }
                    if(up_to_date($pdo, $field, $value, $student)){
                        $errors[] = "The $field for this user is already $value";
                    }
                    if($errors){
                        $_SESSION["update error"] = $errors;
                        header("Location: dashboard.php");
                        die();
                    }else{
                        update_user($pdo, $field, $value, $student);
                        $success = "Student account has been updated";
                        $_SESSION["update success"] = $success;
                        header("Location: dashboard.php");
                    }

                }else if(isset($_POST["verify_all"])){//verify all pending users on admin dashboard
                    verify_all_users($pdo);
                    $success = "All pending users have been verified";
                    $_SESSION["verify_all success"] = $success;
                    delete_all_pending($pdo);
                    header("Location: dashboard.php"); 

                }else if(isset($_POST["add_listing"])){//add listing on admin dashboard
                    $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
  
                    if(!book_exists($pdo, $title, "book")){
                        $errors[] = "$title is has not been listed";
                    }
                        /*
                        if(!book_listed($pdo, $title, "book")){ // add $seller param in in case : students have same book copy 
                            $errors[] = "$title is already for sale";
                        } */

                        // validation becomes obselete if two or more users have the same copy of a book and as a result wont be able to change availablity in 'addlisting();'
                    if($errors){ 
                        $_SESSION["add_listing error"] = $errors;
                        header("Location: dashboard.php");
                        die();

                    }else{
                        addListing($pdo, $title);
                        $success = "$title is now availble for purchase";
                        $_SESSION["add_listing success"] = $success;
                        header("Location: dashboard.php");
                    }
                                       
                }else if (isset($_POST["list_all"])){
                    try{
                        $add_all = "UPDATE book SET available = 'Yes' WHERE available = 'No';";
                        $stmt = $pdo->prepare($add_all);
                        $stmt -> execute();
                    
                        $result = "SELECT * FROM book WHERE available = 'No';";
                        $stmt = $pdo->prepare($result);
                        $stmt -> execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if($row !== null){
                            $success = "All pending books have been listed for sale";
                            $_SESSION["list_all success"] = $success;
                        }
                    }catch(PDOException $e){
                        echo "Error: " . $e->getMessage();
                    }finally{
                        $pdo = null;
                        $stmt = null;
                        header("Location: dashboard.php");
                    }
                }
                else if (isset($_POST["delete_book"])){
                    $remove_title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
                    //$seller = filter_var($_POST["seller"], FILTER_SANITIZE_STRING);
                    if(!book_exists($pdo, $remove_title, "book")){ // add $seller param
                        $errors[] = "Book is currently not for sale , check under pending books";
                    }   
                    if($errors){
                        $_SESSION["delete_book error"] = $errors;
                        header("Location: dashboard.php");
                        die();
                    }else{
                        delete_book($pdo, $remove_title);
                        $success = "$remove_title is no longer for sale";
                        $_SESSION["delete_book success"] = $success;
                        header("Location: dashboard.php");
                    }
                }
            }catch(PDOException $ex){
                echo "Error: " . $ex->getMessage();
            }finally{
                $pdo = null;
                $stmt = null;
            }
        }else{
            header("Location: dashboard.php");
            die();
        }

        function addlisting(object $pdo , string $title){
            $add = "UPDATE book  
                    SET  available = 'Yes'
                    WHERE title = :title;";
                    $stmt = $pdo->prepare($add);
                    $stmt->bindParam(':title', $title);
                    $stmt -> execute();
        }

        function book_listed( object $pdo, string $title , string $table){
            try{
                $check = "SELECT title FROM $table WHERE title = :title AND available = 'Yes';";
                $stmt = $pdo->prepare($check);
                $stmt->bindParam(':title', $title);
                $stmt -> execute();
                if($stmt->rowCount() > 0){
                    return true;}
                else{ return false;}
            }catch(PDOException $e){
                echo "Error: " . $e->getMessage();
            }

        }


        function valid_field( string $field){
            $valid_fields = array("st_num","name","email","password","username");
            if (in_array($field, $valid_fields)){
                return true;
            }
        }

        function up_to_date(object $pdo, string $field , string $new_val ,string $student){
           try{
                $check = "SELECT $field FROM user WHERE st_num = :st_num AND $field = :new_val;";
                $stmt = $pdo->prepare($check);
                $stmt->bindParam(':new_val', $new_val);
                $stmt->bindParam(':st_num', $student);                
                $stmt->execute();
                
                if($stmt->rowCount() > 0){
                    return true;}
                else{ return false;}
           }catch(PDOException $se){
                echo "". $se->getMessage();
           }
        }

        function update_user(object $pdo, string $field , string $value ,string $student){
            try{
                $check = "UPDATE user SET $field = :new_val WHERE st_num = :st_num ";
                $stmt = $pdo->prepare($check);
                $stmt->bindParam(':new_val', $value);
                $stmt->bindParam(':st_num', $student);               
                $stmt->execute();
            }catch(PDOException $e){
              echo "Error: " . $e->getMessage();
            }           
        }


  function find_user(object $pdo, string $search){
    $query = "SELECT st_num , email, username , `name` FROM user WHERE st_num = :search"; 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":search", $search);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  function delete_book( object $pdo ,string $title){
        $find = "DELETE FROM book WHERE title = :title AND available = 'No';";
        $stmt = $pdo->prepare($find);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt -> execute(); 
  }

  function delete_user(object $pdo , string $delete_user){
            $query = "DELETE FROM user WHERE st_num = :username;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $delete_user);
            $stmt -> execute();    
  }

  function exists(object $pdo, string $studentNum, string $table) {
        try {
            $query = "SELECT * FROM $table WHERE st_num = :studentNum;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':studentNum', $studentNum, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) >= 1) {
                return true; // Record exists
            } else {
                return false; // Record does not exist
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function book_exists(object $pdo , string $title , string $table){
        try{
            $query = "SELECT * FROM $table WHERE title = :title";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) >= 1) {
                return true; // Record exists
            } else {
                return false; // Record does not exist
            }
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

    }

    function verify_account( object $pdo, string $studentNum){ //transfer pending user to user table
        try{
            trim($studentNum);
            $transfer_credentials = "INSERT INTO user (`name`, username, st_num, `password`, email)
                                     SELECT `name`, username, st_num, `password`, email
                                     FROM pending_user
                                     WHERE st_num = :studentNum;";
            $stmt = $pdo->prepare($transfer_credentials);
            $stmt->bindParam(':studentNum', $studentNum);
            $stmt -> execute();
            remove_from_pending($pdo, $studentNum); 

            //pass a boolean value to register control script to show user is registered and can log in 
            $_SESSION["approved"] = true;
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
   }

  function remove_from_pending(object $pdo , string $studentNum){ //delete pending user after transfer to user table
    try{
        $delete = "DELETE FROM pending_user WHERE st_num = :studentNum;";
        $stmt = $pdo->prepare($delete);
        $stmt->bindParam(':studentNum', $studentNum);
        $stmt -> execute(); 
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

    function verify_all_users(object $pdo){ //transfer all pending users to user table
    try{
            $transfer = "INSERT INTO user (`name`, username, st_num, `password`, email)
                            SELECT `name`, username, st_num, `password`, email
                            FROM pending_user;";
            $stmt = $pdo->prepare($transfer);
            $stmt -> execute();
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
   }

    function delete_all_pending(object $pdo){
        try{
            $delete = "DELETE FROM pending_user;";
            $stmt = $pdo->prepare($delete);
            $stmt -> execute(); 
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }


?>