<?php
session_start();
require_once("db_connection.php");
if(!isset($_SESSION["register_error"])){
    $_SESSION['register_error'] = array();
}

if(isset($_POST['register'])){
    //validate user input
    if(empty($_POST['first_name'])){
        $_SESSION['register_error'][] = "First name must not be empty!";
    }else if(!ctype_alpha($_POST["first_name"])){
        $_SESSION['register_error'][] = "First name must contain letters only!";
    }else if(strlen($_POST['first_name']) < 2){
        $_SESSION['register_error'][] = "First name must be minimum of 2 characters only!";
    }
    //lastname
    if(empty($_POST['last_name'])){
        $_SESSION['register_error'][] = "Last name must not be empty!";
    }else if(!ctype_alpha($_POST["last_name"])){
        $_SESSION['register_error'][] = "Last name must contain letters only!";
    }else if(strlen($_POST['last_name']) < 2){
        $_SESSION['register_error'][] = "Last name must be minimum of 2 characters only!";
    }
    //email
    if(empty($_POST['email'])){
        $_SESSION['register_error'][] = "Email must not be empty!";
    }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $_SESSION['register_error'][] = "Email is invalid!";
    }
    //password
    if(empty($_POST['password'])){
        $_SESSION['register_error'][] = "Password must not be empty!";
    }else if(strlen($_POST["password"]) < 8){
        $_SESSION['register_error'][] = "Password must be at least 8 characters long!";
    }
    //confirm password
    if(empty($_POST['confirm_password'])){
        $_SESSION['register_error'][] = "Confirm your password!";
    }else if($_POST['password'] !== $_POST['confirm_password']){
        $_SESSION['register_error'][] = "Password does not match!";
    }
    //insert
    if(count($_SESSION['register_error']) === 0){
        $firstName = escape_this_string($_POST['first_name']);
        $lastName = escape_this_string($_POST['last_name']);
        $email = escape_this_string($_POST['email']);
        $password = escape_this_string($_POST['password']);
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $encryptedPassword = md5($password . $salt);
        $query = "INSERT INTO users (first_name, last_name, email, password, salt) VALUES ('{$firstName}', '{$lastName}', '{$email}', '{$encryptedPassword}', '{$salt}')";
        if(run_mysql_query($query)){
            $_SESSION["register_success"] = "Registered successfully!";
        }else{
            $_SESSION["register_error"][] = "Not added successfully!";
        }
    }
    header('Location: login.php');
    //login
}else if(isset($_POST['login'])){
    $email = escape_this_string($_POST['email']);
    $password = escape_this_string($_POST['password']);
    $user_query="SELECT * FROM users WHERE email ='{$email}'";
    $user=fetch_record($user_query);
    $encryptedPassword=md5($password .$user['salt']);
    if(empty($_POST['email'])){
        $_SESSION['login_error'][] = 'Enter your email';
    }else if(empty($_POST['password'])){
        $_SESSION['login_error'][] = 'Enter your password';
    }else{
        $_SESSION['login_error'][] = 'Wrong password';
}
if(count($_SESSION['login_error'])===0||$user['password']==$encryptedPassword){
    $_SESSION['user_id']=$user['id'];
    header("Location:index.php");
}else{
    header('Location: login.php');
}}else if(isset($_POST['add_review'])){
    if(!empty($_POST['review'])){
        $review = escape_this_string($_POST['review']);
        $query = "INSERT INTO reviews (user_id, content) VALUES ({$_SESSION['user_id']},'{$review}')";
        $here=run_mysql_query($query);
    }
    header("Location:index.php");
} else if(isset($_POST["add_reply"])&& isset($_POST['review_id'])){
    if(!empty($_POST['reply'])){
        $reply = escape_this_string($_POST['reply']);
        $reviewId = escape_this_string($_POST['review_id']);
        $query = "INSERT INTO replies (review_id, user_id, content) VALUES ({$reviewId}, {$_SESSION['user_id']}, '{$reply}')";
        $here=run_mysql_query($query);
    }
    header("Location:index.php");
}
else{
    session_destroy();
    header('Location: login.php');
}
?>
