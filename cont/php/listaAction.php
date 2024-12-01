<?php 
require_once '../config.php'; 
session_start();


$redirectURL = "../santiere.php";
if ($_SESSION["rol"] == 'Administrator' || $_SESSION["rol"] == 'Șef șantier' ) {

    if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){ 
        if($_REQUEST['action'] == 'adaugaMuncitor')
        {
            $nume = $_REQUEST['nume']; 
            $s = $link->query("SELECT id FROM angajati WHERE username = '$nume'");
            while($r = $s->fetch_assoc()) {
                $cod = $r["id"];
            }
            $santier = $_REQUEST['santier']; 
            $ore = $_REQUEST['ore']; 
            
            if(!empty($cod) && !empty($nume) && !empty($santier) && !empty($ore)){ 
                $itemData = array( 
                    'id' => $cod,
                    'nume' => $nume, 
                    'santier' => $santier, 
                    'ore' => $ore, 
                ); 
    
                array_push($_SESSION['listaMuncitori'], $itemData);
                $redirectURL = '../santiere.php?last='.$santier.'&ore='.$ore;
            }
        }
        
        elseif($_REQUEST['action'] == 'stergeMuncitor'){ 
            $cnt = $_REQUEST['cnt'];
            $santier = $_REQUEST['santier']; 
            $ore = $_REQUEST['ore']; 
            if(!empty($santier) && !empty($ore))
            {            
                unset($_SESSION['listaMuncitori'][$cnt]);
                $_SESSION["listaMuncitori"] = array_values($_SESSION["listaMuncitori"]);
                $redirectURL = '../santiere.php?last='.$santier.'&ore='.$ore;
            }

        }

        elseif($_REQUEST['action'] == 'trimiteLista'){ 
            if(sizeof($_SESSION['listaMuncitori']) > 0)
            {
                $cntxd = 0;
                foreach($_SESSION['listaMuncitori'] as $muncitor)
                {   
                    $nume = $muncitor["nume"];
                    $nrsantier = $muncitor["santier"];
                    $prezenta = $muncitor["ore"];
                    $sql = "INSERT INTO santier_1 (Nume, Rol, Santier, Prezenta, created) VALUES ('$nume', 'Muncitor','$nrsantier', '$prezenta', NOW())";
                    if(mysqli_query($link, $sql)){
                        $cntxd++;
                    }
                }
                if($cntxd > 0) MesajAdaugare('Raportul a fost trimis cu succes catre administrator.' , 'success');
            }
            $_SESSION['listaMuncitori'] = array();
        }

        elseif($_REQUEST['action'] == 'reseteaza'){ 
            $_SESSION['listaMuncitori'] = array();
        }
    }
}

header("Location: $redirectURL"); 
exit();