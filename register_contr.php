<?php
    declare(strict_types=1); //strict mode
    include ('DBConn.php');  //connects to database
    

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        //assigns form data to local variables after filtering
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);    
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $studentNum = filter_var($_POST['st_num'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $password_confirm = filter_var($_POST['password_confirm'], FILTER_SANITIZE_STRING);

        try {
            //includes required files
            require_once 'DBConn.php';
            require_once 'config_session.inc.php';
            require 'register_model.php';  //includes functions for register page
            
            $errors = [];
            //Checks that the input !null or empty obselete if html form uses required fields 

            /* if (empty($name) || empty($studentNum) || empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
                $errors["empty_val"]= "Fill in all fields";   
            }*/

            //checks that email is valid
            if(validate_email($email) === false) {
               $errors["inv_email"] = "Enter a valid email";
            }

            //checks that entered passwords match AND HASHES PASSWORD
            if(str_contains($password, $password_confirm)) {
               $errors["diff_pswd"] = "Make sure the passwords match";
            } else {
               $salt = bin2hex(openssl_random_pseudo_bytes(16));
               $hashed_password = password_hash($password.$salt, PASSWORD_BCRYPT,['cost' => 12]);
            }

            //checks username availability 
            if (username_taken( $pdo , $username)){
                $errors["usn"] = "Use a different username , that one's taken!";                 
            }

            if($errors){ //loads data to superglobal if errors are found to show UI updates on register page
                $_SESSION["register error"] = $errors;
                $register_data = [
                    "name" => $name,
                    "student_number" => $studentNum,
                    "username" => $username,
                    "email" => $email
                ];        
                $_SESSION["register_data"] = $register_data;       
                header("Location: register.php");
                die();
            }else{ //creates user if no errors 
                create_user( $pdo, $name , $username, $studentNum, $email, $hashed_password);
               
                //sets superglobal to be show UI updates on successful registration submission on 
                $pending = "Registration submitted. Waiting for admin verification!";
                $_SESSION["register success"] = $pending;             
                header("Location: register.php");   
                
                if(isset($_SESSION["approved"])){ // waits for super global to be set from admin dashboard if user is verified
                    $verified = "Registration successful! You can now log in";
                    $_SESSION["register success"] = $verified;  
                    
                    //redirect to page after  all or any changes 
                    header("Location: register.php");                 
                }    
            }

        }catch(PDOException $e) {
            die('Query failed'. $e->getMessage());
        }finally{
            $pdo = null;
            $stmt = null;
        }
    }else{
        header("Location: index.html");  //redirect to home page if the scripts is accessed directly without a POST request 
        die();
    }


?>