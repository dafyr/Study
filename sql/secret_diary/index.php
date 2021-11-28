<?php

    session_start();

    $error = "";  

    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
        session_destroy();
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedinpage.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
        include("connection.php");


        function error_forms() {

            try {
             
                if (!$_POST['email']) {
                    
                    throw new Exception("An email address is required<br>");
                    
                } 
                
                if (!$_POST['password']) {
                    
                    throw new Exception("A password is required<br>");
                    
                } 
             
            } catch (Exception $error) {
                $error = "<p>There were error(s) in your form:</p>".$error;
                $error->getMessage();
                die();
            }
        }

        function sign_up()    {
            
            global $link;

            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken.";
                    die();
                }

                    $query = "INSERT INTO `users` (`email`, `password`) 
                    VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";
                        die();
                    } 

            }

        }

        function set_password() {

            global $link;

            $query = "UPDATE `users` SET password = 
            '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                        
            $id = mysqli_insert_id($link);
                        
            mysqli_query($link, $query);

            $_SESSION['id'] = $id;

            $year = time() + 60*60*24*365;

            if ($_POST['stayLoggedIn'] == '1') {

             setcookie("id", $id, $year);

            } 
        }
                            
            header("Location: loggedinpage.php");

        function log_in() {

            global $link;

            $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
            $result = mysqli_query($link, $query);
                
            $row = mysqli_fetch_array($result);
                
            if (isset($row)) {
                        
                $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                    if ($hashedPassword == $row['password']) {
                            
                        $_SESSION['id'] = $row['id'];
                            
                            if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], $year);

                            } 

                            header("Location: loggedinpage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
            }    
            
        }
        
        
    }


?>

<?php include("header.php"); ?>

<div class="container" id="homePageContainer">

    <h1>Secret Diary</h1>

    <p><strong>Store your thoughts permanently and securely.</strong></p>

    <div id="error"><?php error_forms();  
} ?></div>

    <form method="post" id="signUpForm">

        <?php function sign_up(); ?>

        <p>Interested? Sign up now.</p>

        <fieldset class="form-group">

            <input class="form-control" type="email" name="email" placeholder="Your Email">

        </fieldset>

        <fieldset class="form-group">

            <input class="form-control" type="password" name="password" placeholder="Password">
            <?php function set_password(); ?>

        </fieldset>

        <div class="checkbox">

            <label>

                <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in
                
            </label>

        </div>

        <fieldset class="form-group">

            <input type="hidden" name="signUp" value="1">

            <input class="btn btn-success" type="submit" name="submit" value="Sign Up!">

        </fieldset>

        <p><a class="toggleForms">Log in <?php function log_in(); ?> </a></p>

    </form>

    <form method="post" id="logInForm">

        <p>Log in using your username and password.</p>

        <fieldset class="form-group">

            <input class="form-control" type="email" name="email" placeholder="Your Email">

        </fieldset>

        <fieldset class="form-group">

            <input class="form-control" type="password" name="password" placeholder="Password">

        </fieldset>

        <div class="checkbox">

            <label>

                <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in

            </label>

        </div>

        <input type="hidden" name="signUp" value="0">

        <fieldset class="form-group">

            <input class="btn btn-success" type="submit" name="submit" value="Log In!">

        </fieldset>

        <p><a class="toggleForms">Sign up</a></p>

    </form>

</div>

<?php include("footer.php"); ?>
