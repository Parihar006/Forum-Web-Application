<?php

echo "You are logging out. Please wait...";
session_start();
session_destroy();
header("location:/forum?loggedoutsuccess=true");

?>