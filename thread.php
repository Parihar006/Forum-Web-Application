<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 450px;
    }
    </style>
    <title>Welcome to iDiscuss - coding forum</title>
</head>

<body>

    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>

    <?php
    $threadId = $_GET['threadid'];
    $thread_user_id = $_GET['thread_user_id'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$threadId";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $threadTitle = $row['thread_title'];
    $threadDesc = $row['thread_description'];

    $sql2 = "SELECT * FROM `users` WHERE sno=$thread_user_id";
    $result2 = mysqli_query($conn,$sql2);
    $row2=mysqli_fetch_assoc($result2);
    ?>

    <?php
    $showAlert = false;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $showAlert=true;
        $content = $_POST['content'];
        $content = str_replace("<","&lt;",$content);
        $content = str_replace(">","&gt;",$content);
        $thread_id = $_GET['threadid'];
        $user_id = $_SESSION['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`,`user_id`) VALUES ('$content', '$thread_id', current_timestamp(), '$user_id')";
        $result = mysqli_query($conn,$sql);
    }

    if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong>Your comment has been posted.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $threadTitle; ?></h1>
            <p class="lead"><?php echo $threadDesc; ?></p>
            <hr class="my-4">
            <p>No Spam / Advertising / Self-promote in the forums.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Do not PM users asking for help.
                Remain respectful of other members at all times.</p>
            <p class="lead">
            <p><b>posted by : <?php echo $row2['user_email']; ?><b></p>
            </p>
        </div>
    </div>

    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container">
                <h1>Post a comment</h1>
                <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                    <div class="form-group my-2">
                        <label for="content">Type comment</label>
                        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
    }
    else{
        echo '<div class="container">
                <h1>Post a comment</h1>
                <p>Please login to post comments.</p>
            </div>';
    }

    ?>

    <div class="container py-2" id="ques">
        <h1>Discussion</h1>
        <?php
        $threadId = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$threadId";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
        while($row=mysqli_fetch_assoc($result)){
            $noResult=false;
            $content = $row['comment_content'];
            $user_id = $row['user_id'];
            $sql2 = "SELECT * FROM `users` WHERE sno=$user_id";
            $result2 = mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            echo '<div class="media my-4">
                    <img class="mr-3" src="img/user_default.png" width="40px" alt="Generic placeholder image">
                    <h6 class="mt-0">'.$row2['user_email'].'                  at '.$row['comment_time'] .'</h6>          
                    <div class="media-body">  
                    '.$content.'
                    </div>
                    
                </div>';
        }

        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
              <p class="display-4">No Comments found</p>
              <p class="lead">Be the first person to post a comment.</p>
          </div>';
        }

        ?>
    </div>

    <?php include 'partials/_footer.php'; ?>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>