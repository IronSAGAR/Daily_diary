<?php

    session_start();

    if (array_key_exists("logout", $_GET)){
        session_unset();
        setcookie("id","",time() - 60*60*24);
        $_COOKIE["id"] = "";
    }
    else if (array_key_exists("id", $_SESSION) OR array_key_exists("id", $_COOKIE)){
        header("Location:loggedinpage.php");
    }





    $error = "";
    if (array_key_exists("submit" ,$_POST)){
        // $username = "Celestial69";
        // $servename = "localhost";
        // $password = "mysqlpass@654";
        
        $link =  new mysqli("localhost", "Celestial69", "mysqlpass@654", "daily_diary");

        if ($link->connect_error) {
            die("Connection failed: ". $link->connect_error);
        }
        

        if (!$_POST["email"]){
            $error .= "an email is required.<br>";
            
        }
        
        if (!$_POST["password"]){
            $error .= "a password is required.<br>";
            
        }

        if ($error != ""){
            $error = "<p>There were some errors in your form!</p>" . $error;
            
        }
        else{
            $email = mysqli_real_escape_string($link, $_POST["email"]);


            if($_POST['signUp'] == '1'){
                $query = "SELECT id FROM users WHERE email = '" . $email . "' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {
                    $error = "This email is already in use.<br>";
                    
                }
                else {

                    $password = mysqli_real_escape_string($link, $_POST["password"]);
                    $password = password_hash($password , PASSWORD_DEFAULT);


                    $query = "INSERT INTO users (email, password) VALUES ('". $email. "','". $password. "')";

                    if(!mysqli_query($link, $query)){
                        $error .= "<p> Could not sign up - Please try again later.</p>";
                        $error .= "<p>" . mysqli_error($link) . "</p>";
                        
                    }
                    else{
                        

                        $id = mysqli_insert_id($link);

                        $_SESSION['id'] = $id;

                        if (isset($_POST['stayLoggedIn'])){
                            setcookie("id" , $id, time() + 60 * 60 *24 * 365);
                        }

                        header("Location: loggedinpage.php");
                    }
                }
            }
            else{
                $query = "SELECT * FROM users WHERE email = '".$email."'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);

                $password = mysqli_real_escape_string($link , $_POST['password']);

                if (isset($row) AND array_key_exists("password", $row)){
                    $passwordMatch = password_verify($password , $row['password']);

                    if ($passwordMatch){
                        $_SESSION['id'] = $row['id'];

                        if (isset($_POST['stayLoggedIn'])){
                            setcookie("id", $row['id'], time() + 60 * 60 *24 * 365);
                        }

                        header("Location: loggedinpage.php");
                    }
                    else{
                        $error = "invalid email/password.";
                        
                    }
                }
                else{
                    $error = "invalid email/password.";
                    
                }
            }



            
        }
        
    }


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Diary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <style>
        body{
            background-image: url("bg-img.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.2);
            margin: 0px;
            padding: 0px;
        }

        .heading{
            margin-top: 16vh;
            font-size: 8vw;
            font-family: 'Dancing Script', cursive;
            color: black;
            text-shadow: 2px 2px white;
        }

        .forms{
            margin: 50px;
            max-width: 500px;
            padding: 10px;
            border: 1px white solid;
            
            padding: 3vh 2vw;
            border-radius: 10%;
            box-shadow: inset 0 0 0 1000px rgba(255, 255, 255, 0.2);
            
        }
        .error{
            color:white;
            font-size: 1vw;
            max-width: 40vw;
            height: 5vh;
            /* background-color: rgba(228, 27, 27, 0.2); */
            text-align: center;
           
        }
    </style>


</head>
<body>


    <div class="container text-center heading" >
        <span>Daily Diary</span>
    </div>


    
    <div class="d-flex justify-content-around" >
        <!-- sign up form -->
        <div class="forms container">
            <h2 class="text-center">Sign Up</h2>
            <form method = "post">
                <div class="mb-3">
                    <input type="email"  name = "email"  placeholder = "Your email" class="form-control" >
                </div>
                <div class="mb-3">
                <input type="password"  name = "password" placeholder = "Password" class="form-control">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox"  name = "stayLoggedIn"  value = "1" class="form-check-input">
                </div>
                <input type="hidden" name = "signUp" value = "1">
                
                <input type="submit" name="submit" value = "Sign Up!" class="btn btn-primary">
            </form>
            
        </div>
    
 
        <!-- log in form -->
        <div class="forms container">
            <h2 class="text-center">Sign In</h2>
            <form method = "post">
                <div class="mb-3">
                    <input type="email"  name = "email"  placeholder = "Your email" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="password"  name = "password" placeholder = "Password" class="form-control"> 
                </div>
                <div class="mb-3">
                    <input type="checkbox"  name = "stayLoggedIn"  value = "1" class="form-check-input">
                </div>
                <input type="hidden" name = "signUp" value = "0" >
                
                <input type="submit" name="submit" value = "Log In!" class="btn btn-success">
            </form>
            
        </div>
    </div>


    

    <div class = "error container text-center" id = "err"><?php echo $error; ?> </div>

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></>

   

</body>
</html>
