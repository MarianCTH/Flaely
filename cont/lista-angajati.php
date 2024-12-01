<?php
    include("config.php");  
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    $zile = 7; 
    $prezentazile = null;
    if(isset($_POST['prezentazile'])){
        $prezentazile = $_POST['prezentazile'];
    }
    switch($prezentazile){
        case '7zile': $zile = 7; break;
        case '14zile': $zile = 14; break;
        case '30zile': $zile = 30; break;
        default: $zile = 7; break;
    }

    // generating orderby and sort url for table header
    function sortorder($fieldname){
        $sorturl = "?order_by=".$fieldname."&sort=";
        $sorttype = "asc";
        if(isset($_GET['order_by']) && $_GET['order_by'] == $fieldname){
            if(isset($_GET['sort']) && $_GET['sort'] == "asc"){
                $sorttype = "desc";
            }
        }
        $sorturl .= $sorttype;
        return $sorturl;
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
	<meta lang="ro">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/main-lista-angajati.css">
    <title>Flaely GRUP - Listă Angajați</title>
</head>
<body>
<?php if ($_SESSION["rol"] == 'Administrator') { ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" style="width: 1180px;">
                <div class="text-center">
                    <h1 style = "padding-bottom: 25px;">Listă Angajați - Flaely GRUP</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead><tr><th style="text-align:center"> Nr. crt.</th>
                            <th style="text-align:center"><a href="<?php echo sortorder('username'); ?>" class="sort">Nume</a></th>
                            <th style="text-align:center"><a href="<?php echo sortorder('rol'); ?>" class="sort">Rol</a></th>
                            <th style="text-align:center"><form name="myform" action="" method="post">
                            Prezență
                            <select name="prezentazile" id="myselect" onChange="this.form.submit()">
                                <option value="7zile" <?php if($prezentazile == "7zile"){ echo " selected"; }?>>7</option>
                                <option value="14zile" <?php if($prezentazile == "14zile"){ echo " selected"; }?>>14</option>
                                <option value="30zile" <?php if($prezentazile == "30zile"){ echo " selected"; }?>>30</option>
                            </select> zile
                        </form></th>
                            </thead>
                            <tbody>
                                <?php
                                    // selecting rows
                                    $orderby = " ORDER BY id desc ";
                                    if(isset($_GET['order_by']) && isset($_GET['sort'])){
                                        $orderby = ' order by '.$_GET['order_by'].' '.$_GET['sort'];
                                    }

                                    $db = $link;

                                    $query = "SELECT id, username, password, rol from angajati ".$orderby." ";
                                    $result = $db->query($query);
                                    $contor = 1;
                                    if($result== true)
                                    {
                                        if ($result-> num_rows > 0){
                                            while($row = $result-> fetch_assoc()){
                                                $cnt_2sapt = 0;
                                                $xd = "SELECT * FROM `santier_1` 
                                                        WHERE `created` BETWEEN date_sub(NOW(), INTERVAL $zile DAY) AND NOW() 
                                                        AND `Nume` = '".$row['username']."' ";
                                                $result_2sapt = $db->query($xd);
                                                if($result_2sapt == true)
                                                {
                                                    if ($result_2sapt-> num_rows > 0)
                                                        while($row2 = $result_2sapt-> fetch_assoc()) 
                                                            $cnt_2sapt+=$row2['Prezenta'];
                                                }  
                                                echo "<tr>
                                                    <td>". $contor ."</td>
                                                    <td>". $row["username"] ."</td>
                                                    <td>". $row["rol"] ."</td>
                                                    <td>". $cnt_2sapt ." ore</td>
                                                    </tr>";
                                            $contor++;
                                            }
                                            ?>
                                            <td colspan="2" class="table-active table-dark" style="font-size: 20px;">Total Angajati: </td>
                                            <td colspan="3" class="table-active table-dark" style="font-size: 25px;"> <?php echo $contor-1 ."</td>";
                                            echo "</table>";
                                        }
                                        else{
                                            echo "Nu a fost gasit nici un rezultat.";
                                        }                        
                                    }
                                    else{
                                        echo "Eroare baza de date.";
                                    }
                                ?>
                            </tbody>
                        </table>  
                    </div>  
                <div class="text-center p-t-80">
                    <a class="txt2 footer" href="main.php">
                    <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                        Înapoi la pagina de administrare
                    </a>
                </div>

            </div>  
        </div>
    </div>
<?php } else header("location: login.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>