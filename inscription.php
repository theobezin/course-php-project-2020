<?php
include 'templates/header.php';
include 'database.php';



if (isset($_SESSION['id'])){
    header('Location : home.php');
    exit;
}

if(!empty($_POST)){
    extract($_POST);
    $valid = true;

    if(isset($_POST['submit-inscription'])){
        $nickname =  $_POST['nickname'] ?? null;
        $email = $_POST['email'] ?? null;
        $plainPassword = $_POST['password'] ?? null;
        $verificationPassword = $_POST['verificationPassword'] ?? null;

        if(empty($nickname)){
            $valid = false;
            $error_nickname = ('Please enter a nickname');
        }else{
            $check_pseudo = $db -> prepare("SELECT nickname FROM user WHERE nickname = ?");
            $check_pseudo->execute([$nickname]);

            if($check_pseudo->rowCount() >= 1){
                $valid = false;
                $error_nickname = "This nickname isn't available";
            }
        }

        if(empty($plainPassword)){
            $valid = false;
            $error_password = "Password can't be empty";
        }elseif ($plainPassword != $verificationPassword){
            $valid = false;
            $error_password = "Passwords aren't the same";
        }

        if(empty($email)){
            $valid = false;
            $error_email = "Please enter your email";
        }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $email)){
            $valid = false;
            $error_email = "Your email isn't valid";
        }else{

            $check_email = $db->query("SELECT email FROM user WHERE email = ?");
            var_dump($email, $check_email);
            $check_email->execute([$email]);

            if($check_email->rowCount() >= 1){
                $valid = false;
                $error_email = "This email is already used";
            }
        }
    }
    if($valid){
        $password = password_hash($plainPassword, PASSWORD_DEFAULT);
        $data = [$nickname, $email, $password];
        $query = $db->prepare('INSERT INTO projetphp.user(nickname, email, password) VALUES (?,?,?)');
        $result = $query->execute( $data);

    }

}
?>

<form id="inscription" method="POST">
    <h2>Registration</h2>


    <img src="https://img.icons8.com/windows/32/000000/user.png">
    <input type="input" name="nickname" placeholder="Nickname" >
    </br>
    <img src="https://img.icons8.com/material-two-tone/24/000000/email.png">
    <input type="input" name="email" placeholder="Email" >
    </br>

    <img src="https://img.icons8.com/metro/26/000000/password.png">
    <input type="password" name="password" placeholder="Password" > </br>
    <img src="https://img.icons8.com/metro/26/000000/re-enter-pincode.png">
    <input type="password" name="verificationPassword" placeholder="Repeat your password" > </br>
    <?php


    if(isset($error_nickname)){
        echo '<i>'.'<p>'.$error_nickname.'</p>'.'</i>' ;
    }

    if(isset($error_email)){
        echo '<i>'.'<p>'.$error_email.'</p>'.'</i>' ;
    }
    if(isset($error_password)){
        echo '<i>'.'<p>'.$error_password.'</p>'.'</i>' ;
    }
    ?>
    <input type="submit" name="submit-inscription" value="Register">


</form>
