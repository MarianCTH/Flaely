<?php
    include('../config.php');

    if(isset($_GET['Cod']))
    {
        $id=$_GET['Cod'];
        $query1 = mysqli_query($link, "DELETE from materiale WHERE Cod='$id'");
        if($query1)
        {
            header('location:../materiale-furnizor.php');
        }
    }
?>