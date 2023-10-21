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





</head>
<body>

    <div class="navbar">
        <h2>Your Diary</h2>
        <a href="index.php?logout=1">
                <button class="btn btn-success-outline">Logout</button>
        </a>
    </div>

    <form method="post">
        <textarea name="content" id="content" class = "form-control" rows="10">
            <?php echo $diaryContent; ?>
        </textarea>
        <input type="submit" name ="submit" value="submit">
    </form>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></>

</body>
</html>
