
<?php
    include('../config.php');

    if(isset($_GET['Cod']))
    {
        $id=$_GET['Cod'];
        if(isset($_POST['update']))
        {
            $cantitate=$_POST['cantitate'];
            $santier=$_POST['santier'];
            $termen=$_POST['termen'];
            $sql = "UPDATE materiale set Cantitate='$cantitate', Santier='$santier', Termen='$termen' WHERE Cod='$id'";
            $query3 = $link->query($sql);
            if($query3)
            {
                echo "<script> window.location.href = '../materiale-comandate.php'; </script>";
            }
        }
        $query1=mysqli_query($link,"SELECT * from materiale where Cod='$id'");
        $query2=mysqli_fetch_array($query1);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
    <link rel="stylesheet" type="text/css" href="../css/style-welcome.css">
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
    <title>Flaely GRUP - Modificare Comandă</title>
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="padding-top: 20px !important">
                <div class="col m-1">
                    <div class="text-center">
                        <h1 style="margin-bottom: 45px;">Modifică istoricul comenzii al materialului selectat</h1>
                    </div>

                    <form method="post" action="">
                        <h4 style="padding-bottom: 5px;" class="text-center">Cantitate</h4>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="cantitate" value="<?php echo $query2['Cantitate']; ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <h4 style="padding-bottom: 5px;" class="text-center">Șantier</h4>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="santier" value="<?php echo $query2['Santier']; ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <h4 style="padding-bottom: 5px;" class="text-center">Termen Livrare</h4>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="date" name="termen" value="<?php echo $query2['Termen']; ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100">
                            <input class="login100-form-btn" type="submit" name="update" value="Editează">
                        </div>
                    </form>
                    </div>
                    <div class="text-center p-t-80">
                        <a class="txt2" href="../materiale-comandate.php">
                        <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                            Înapoi la istoricul comenzilor
                        </a>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</body>
</html>