<?php
        declare(strict_types= 1);
        include('DBConn.php');


        function user_exists(object $pdo , string $user_username){     
                $query = "SELECT username FROM user WHERE username = :user_username;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':user_username', $user_username);
                $stmt->execute();          
                if ($stmt->rowCount() > 0) {return true;}else{ return false;}                    
        }

        function input_match(object $pdo, string $user_username, string $user_password, string $tbl_name) {
            $query = "SELECT username , `password` FROM $tbl_name WHERE username = :user_username;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_username', $user_username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($row && ($row['password']) === $user_password )  {  //password_verify($user_password,$row['password']
                return true; // Username and password match
            } else {
                return false; // Username and password do not match or user not found
            }
        }
        
     function get_user_id(object $pdo , string $username) : int{
        $query = "SELECT user_id FROM user WHERE username = :user_username";
        $stmt  = $pdo-> prepare($query);
        $stmt->bindParam(':user_username', $username);
        $stmt->execute();
        $id = $stmt->fetch();
        return intval($id['user_id']);
      }

        function admin_exists(object $pdo , string $user_username){
            $query = "SELECT username FROM `admin` WHERE username = :user_username;";
            $stmt  = $pdo-> prepare($query);
            $stmt->bindParam(':user_username', $user_username);
            $stmt->execute();
            if($stmt->rowCount() >= 1){return true;}else{ return false;}
        }
?>