<?php
    include_once("config.php");
    include_once('libs/tfpdf.php');

    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    
    class PDF extends TFPDF
    {   
      function Header()
      {
          // Logo
          $this->Image('images/img-01.png',30,2,30);
          $this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
          $this->SetFont('DejaVu','',44);
          // Move to the right
          $this->Cell(80);
          // Title
          $this->Cell(65,15,'Raport Angajați',0,2,'C');
          // Line break
          $this->Ln(15);
      }
      
      function Footer()
      {
          // Position at 1.5 cm from bottom
          $this->SetY(-15);
          // Arial italic 8
          $this->SetFont('Arial','I',8);
          // Page number
          $this->Cell(200,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
      }
    }
    
    $db = $link;
    $de_la = mysqli_real_escape_string($db, $_POST['de_la']);
    $pana_la = mysqli_real_escape_string($db, $_POST['pana_la']);
    $result = mysqli_query($db, "SELECT Nume, Prezenta, Santier, created FROM santier_1 WHERE created >= '$de_la' AND created <= '$pana_la' ORDER BY created DESC");
    
    $pdf = new PDF();
    $pdf->SetLeftMargin(5);
    //header
    $pdf->AddPage();
    $pdf->SetFont('DejaVu','',20);
    $pdf->Cell(145,5,$de_la,0,0,'C');
    $pdf->Cell(-100,5,' - ',0,0,'C');
    $pdf->Cell(145,5,$pana_la,0,0,'C');
    $pdf->Ln(15);

    $pdf->AddFont('DejaVuB','','DejaVuSansCondensed-Bold.ttf',true);
    $pdf->SetFont('DejaVuB','',20);
    $pdf->Cell(50,12,'Angajat',1);
    $pdf->Cell(50,12,'Prezență',1);
    $pdf->Cell(50,12,'Șantier',1);
    $pdf->Cell(50,12,'Dată',1);

    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',14);
    $pdf->SetFillColor(255,0,0);
    $pdf->SetLineWidth(.3);
    //foter page
    $pdf->AliasNbPages();

    foreach($result as $row) 
    {
      $pdf->Ln();
      $pdf->Cell(50,12,$row['Nume'],1);
      $pdf->Cell(50,12,$row['Prezenta'] . ' ore',1);
      $pdf->Cell(50,12,$row['Santier'],1);
      $pdf->Cell(50,12,$row['created'],1);
    }
    $pdf->Output();
?>