<?php

    session_start();
    $diaryContent = "";
    if (array_key_exists("id",$_COOKIE)){
        $_SESSION['id'] = $_COOKIE['id'];
    }

    if (array_key_exists("id",$_SESSION)){
        include('connection.php');
        $id = mysqli_real_escape_string($link, $_SESSION['id']);

        $query = "SELECT diary FROM users WHERE id = '".$id."' LIMIT 1";

        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        $diaryContent = $row['diary'];

        
        
    }
    else{
        header("Location:index.php");
    }

    if (array_key_exists("submit", $_POST)){
        
        
        $content = $_POST["content"];

        $query = "UPDATE users SET diary = '".$content."' WHERE id = '".$id."' LIMIT 1";

        mysqli_query($link,$query);
        $query = "SELECT diary FROM users WHERE id = '".$id."' LIMIT 1";

        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        $diaryContent = $row['diary'];
        
    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Diary</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fasthand&family=Noto+Sans:ital,wght@1,300&family=Playfair+Display:ital,wght@1,400;1,700&family=Poppins&family=Qwitcher+Grypen:wght@700&display=swap" rel="stylesheet">

    <style>
        body{
            background-image: url("img/diary2-img.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            
            margin: 0px;
            padding: 0px;
        }
        
        .head{
            margin-bottom: 5vh;
            font-family: 'Poppins', sans-serif;
            color: white;
            font-size: 400%;
            background-color: rgba(0,0,0,0.5); 
            width: 100vw;
            padding: 1vh 10vw;
        }
       
        

    </style>

</head>
<body>

    <div class="navbar head">
        <span>Your Diary</span>
        <a href="index.php?logout=1">
                <button class="btn btn-outline-primary">Logout</button>
        </a>
    </div>

    <div class="container">
        <form method="post">
            <div class = "mb-3">
                <textarea name="content" id="content" class = "form-control" rows="10">
                    <?php echo $diaryContent; ?>
                </textarea>
            </div>
            <div class="mb-3">
                <input type="submit" name ="submit" value="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></>

</body>
</html>
