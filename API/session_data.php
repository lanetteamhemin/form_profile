<?php

if(isset($_POST['id']))
{
    require_once("../con.php");
    session_start();
    $id=$_POST['id'];

    echo $id."<br>";
    $select_user_query="select * from sample where id=".$id;
    $result=mysqli_query($con,$select_user_query);

    if($row=mysqli_fetch_assoc($result))
    {
        $_SESSION['id']=$row['id'];
        $_SESSION['name']=$row['name'];
        $_SESSION['email']=$row['email'];
        $_SESSION['password']=$row['password'];
        $_SESSION['profile']=$row['profile'];

        echo $_SESSION['name']."<br>";
    }
    else
    {
        echo "session destroy";
        session_destroy();
    }
    echo "session data store";
}
else
{
    echo "fail";
}

?>