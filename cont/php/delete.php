<?php
    include('../config.php');

    if(isset($_GET['id']))
    {
        $id=$_GET['id'];
        $query1 = mysqli_query($link, "DELETE from sesiune_sefsantier_comanda WHERE id='$id'");
        if($query1)
        {
            header('location:../materiale.php');
        }
    }
?>