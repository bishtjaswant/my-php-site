<?php
require_once './init/db.php';


$isEmailAvailable=function(String $email) use ($conn)  {

    $sql="SELECT email  FROM users WHERE email = '$email' ";
    $result = $conn->query($sql);
    return $result->num_rows ;
};

