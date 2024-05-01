<?php
include('DBConn.php');

// Drop and recreate the 'admin' table
try {
    $sql = "DROP TABLE IF EXISTS `admin`;
    CREATE TABLE IF NOT EXISTS `admin` (
    `admin_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`admin_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
    $stmt = $pdo->query($sql);
    $stmt->execute();
} catch (PDOException $e) {
    die("ERROR: Could not execute SQL for 'admin' table. " . $e->getMessage());
}

// Continue with other code after 'admin' table creation

try {
    $sqlbook = "DROP TABLE IF EXISTS `book`;
    CREATE TABLE IF NOT EXISTS `book` (
    `book_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `author` varchar(255) NOT NULL,
    `edition` varchar(255) NOT NULL,
    `condition` enum('Like_New','Worn','Dying') NOT NULL,
    `isbn` varchar(255) NOT NULL,
    `release_year` year NOT NULL,
    `description` varchar(255) NOT NULL,
    `available` enum('Yes','No') NOT NULL,
    `publisher` varchar(255) NOT NULL,
    `price` double NOT NULL,
    `listing_id` bigint DEFAULT NULL,
    PRIMARY KEY (`book_id`),
    KEY `listing_id` (`listing_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
    $stmt = $pdo->query($sqlbook);
    $stmt->execute();
} catch (PDOException $e) {
    die("ERROR: Could not execute SQL for 'book' table. " . $e->getMessage());
}

// Continue with other code after 'book' table creation

try{
    $sqllisting = "DROP TABLE IF EXISTS `listing`;
    CREATE TABLE IF NOT EXISTS `listing` (
      `listing_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` bigint NOT NULL,
      `book_id` bigint NOT NULL,
      `date` date NOT NULL,
      PRIMARY KEY (`listing_id`),
      KEY `user_id` (`user_id`),
      KEY `book_id` (`book_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
    $stmt = $pdo->query($sqllisting);
    $stmt->execute();
}catch(PDOException $e){
    die("ERROR: Could not execute SQL for 'listing' table. " . $e->getMessage());
}


try{
    $spqPending_user = "DROP TABLE IF EXISTS `pending_user`;
    CREATE TABLE IF NOT EXISTS `pending_user` (
      `pendingUser_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `username` varchar(255) NOT NULL,
      `st_num` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      PRIMARY KEY (`pendingUser_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

}catch(PDOException $e){
    die("ERROR: Could not execute SQL for 'pending_user' table. " . $e->getMessage());
}

try{
    $sqlUser = "DROP TABLE IF EXISTS `user`;
    CREATE TABLE IF NOT EXISTS `user` (
      `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `username` varchar(255) NOT NULL,
      `st_num` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `listing_id` bigint DEFAULT NULL,
      `book_id` bigint DEFAULT NULL,
      PRIMARY KEY (`user_id`),
      KEY `listing_id` (`listing_id`),
      KEY `book_id` (`book_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    COMMIT;"; 
}catch(PDOException $e){
    die("ERROR: Could not execute SQL for 'user' table. " . $e->getMessage());  
}

try{
    $sql = "load data infile '_sample_data/sampleBooks.csv' 
    into table book fields terminated by ',' lines terminated by '\n'
    (title, author, edition, condition, isbn, release_year, description, available, publisher, price,listing_id);
       
    load data infile '_sample_data/sampleUser.csv' into table user fields terminated by ',' 
    (name, username, st_num, password, email);

    load data infile '_sample_data/samplePendingUser.csv' into table pending_user fields terminated by ','
    (name, username, st_num, email, password);

    load data infile '_sample_data/sampleAdmin.csv' into table admin fields terminated by ','
    (name, username, password);";
}catch(PDOException $e){
    die("ERROR: Could not execute SQL for 'load data' table. " . $e->getMessage());  
}
?>
