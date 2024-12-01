<?php
    include('../config.php');

    if(isset($_GET['Cod']))
    {
        $id=$_GET['Cod'];
        $query1 = mysqli_query($link, "UPDATE materiale SET status = 'Livrat' WHERE Cod='$id'");
        if($query1)
        {
            header('location:../materiale-comandate.php');
        }
    }
?>