<?php

    declare (strict_types= 1);
    include ('DBConn.php');
    function validate_email($email) {
        // Regular expression pattern for a valid email address
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    
        // Use preg_match to perform the validation
        if (preg_match($pattern, $email)) {
            return true;
        } else {
            return false;
        }
    }
    
    function username_taken(object $pdo , string $username){
        if(get_username( $pdo , $username)){
              return true;  
        } else{
            return false;
        }
    }

    function get_username( object $pdo ,string $username){
        $query = "SELECT username FROM user WHERE username = :username; ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function create_user( object $pdo ,string $name, string $username, string $studentNum, string $email, string $hashed_password) {
        try {
            $sql = "INSERT INTO pending_user (name, username, st_num, email, password) VALUES (:name, :username, :studentNum, :email, :hashed_password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':studentNum', $studentNum);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':hashed_password', $hashed_password);
            $stmt->execute();            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $pdo = null;
            $stmt = null;           
        }
   }
?>