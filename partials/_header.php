<?php

session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="/forum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/forum">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/forum/about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Top Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

                $sql = "SELECT * FROM `categories` LIMIT 3";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                    echo '<li><a class="dropdown-item" href="threadlist.php?catid=' .$row['category_id']. '">' .$row['category_name']. '</a></li>';
                }
                echo '</ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/forum/contact.php">Contact</a>
            </li>
        </ul>
        <form class="d-flex" action="search.php" method="get">
            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
        </form>';

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo '
            <p class="text-light my-2 mx-2">welcome '.$_SESSION['useremail'].'</p>
            <div class="cloumn mx-2">                                    
                <a href="/forum/partials/logout.php" class="btn btn-outline-success mr-2">Logout</a>                   
            </div>
            ';
        }
        else{
            echo '<div class="cloumn mx-2">                                    
                    <button class="btn btn-outline-success mr-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>                    
                  </div>';
        }
        echo '
    </div>
</div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Registered successfully. You can login now
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
    $error = $_GET['error'];
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    ' .$error. '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

if(isset($_GET['loggedoutsuccess']) && $_GET['loggedoutsuccess']=="true"){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong></strong>Logged out successfully
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

// if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==false){
//     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
//     ' .$_SESSION['loginerror']. '
//     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//   </div>';
// }

?>