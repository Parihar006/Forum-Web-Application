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
    $catId = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$catId";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $categoryName = $row['category_name'];
    $categoryDescription = $row['category_description'];
    ?>

    <?php
    $showAlert = false;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $showAlert=true;
        $th_title = $_POST['title'];
        $th_title = str_replace("<","&lt;",$th_title);
        $th_title = str_replace(">","&gt;",$th_title);

        $th_desc = $_POST['desc'];
        $th_desc = str_replace("<","&lt;",$th_desc);
        $th_desc = str_replace(">","&gt;",$th_desc);

        $cat_id = $_GET['catid'];
        $thread_user_id = $_SESSION['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_description`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$cat_id', '$thread_user_id', current_timestamp())";
        $result = mysqli_query($conn,$sql);
    }

    if($showAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success! </strong>Your thread has been added.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $categoryName; ?> forum</h1>
            <p class="lead"><?php echo $categoryDescription; ?></p>
            <hr class="my-4">
            <p>No Spam / Advertising / Self-promote in the forums.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Do not PM users asking for help.
                Remain respectful of other members at all times.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container">
                <h1>Start a discussion</h1>
                <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                    <div class="form-group">
                        <label for="title">Problem Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="title"
                            placeholder="Enter title">
                        <small id="emailHelp" class="form-text text-muted">Keep the title small.</small>
                    </div>
                    <div class="form-group my-2">
                        <label for="desc">Elaborate your concern</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
    }
    else{
        echo '<div class="container">
                <h1>Start a discussion</h1>
                <p>Please login to start a dicussion.</p>
            </div>';
    }

    ?>

    <div class="container py-2" id="ques">
        <h1>Browse Questions</h1>
        <?php
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$catId";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
        while($row=mysqli_fetch_assoc($result)){
            $noResult=false;
            $title = $row['thread_title'];
            $desc = $row['thread_description'];
            $threadId = $row['thread_id'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT * FROM `users` WHERE sno=$thread_user_id";
            $result2 = mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            echo '<div class="media my-4">
                    <img class="mr-3" src="img/user_default.png" width="40px" alt="Generic placeholder image">
                    <h6 class="mt-0">'.$row2['user_email'].'                  at '.$row['timestamp'] .'</h6> 
                    <div class="media-body">
                        <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' .$threadId. '&thread_user_id=' .$thread_user_id. ' ">' .$title. '</a></h5>
                        ' .$desc. '
                    </div>
                </div>';
        }

        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
                    <p class="display-4">No Threads found</p>
                    <p class="lead">Be the first person to ask a question.</p>
                </div>';
        }

        ?>

        <!-- <div class="media my-3">
            <img class="mr-3" src="img/user_default.png" width="40px" alt="Generic placeholder image">
            <div class="media-body">
                <h5 class="mt-0">Pyton ka saval h</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
                odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div> -->
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