<?php
    session_start();
    require_once 'PDO.php';

 

    $salt = 'XyZzy12*_';
    $stored_hash = hash('md5', 'XyZzy12*_php123');

    if(isset($_POST['cancel'])){
        header("Location: index.php");
        return;
    }

    if(isset($_POST['who']) && (isset($_POST['pass']))){
        if(strlen($_POST['who'])<1 || strlen($_POST['pass']<1)){
            $_SESSION['error'] = "User name and password are required";
            header("Location:login.php");
            return;
        }
        else if(strpos($_POST['who'], "@") === false){
            $_SESSION['error']  = "Email must have an at-sign (@)";
            header("Location:login.php");
            return;
        }
        else{
            $hash_md5 = hash('md5', $salt.$_POST['pass']);
            if($hash_md5 == $stored_hash){
                $_SESSION['name'] =$_POST['who'];
                error_log("Login success ".$_POST['who']);
                header("Location:index.php");
                return;

                
            }
            else{
                $_SESSION['error']  = "Incorrect password";
                error_log("Login fail ".$_POST['who']." $hash_md5");
                header("Location:login.php");
                return;

            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fredy Orozco (60f67dd2)'s Login Page</title>
    <?php require_once 'bootrap.php'; ?>
</head>
<body>
    <div class="container">
        <h1>Please login</h1>
        <?php
            if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
            }
    ?>
        <form method="post">
            <label for="name">email</label>
            <input type="text" name="who" id="name">
            <br>
            <label for="id_1723">Password</label>
            <input type="text" name="pass" id="id_1723">
            <input type="submit" value="Log In">
            <input type="submit" value="Cancel" name="cancel">
        </form>
        <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
        <!-- Hint: The password is the four character sound a cat
        makes (all lower case) followed by 123. -->
    </p>
    </div>
</body>
</html>