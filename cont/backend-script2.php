<?php
    include('config.php'); 
    $searchTerm = $_GET['term'];
    $sql = "SELECT * FROM mat WHERE DenumireMat LIKE '%".$searchTerm."%'"; 
    $result = $link->query($sql); 
    if ($result->num_rows > 0) {
        $tutorialData = array(); 
        while($row = $result->fetch_assoc()) {
            $data['Cod']    = $row['Cod']; 
            $data['value'] = $row['DenumireMat'];
            array_push($tutorialData, $data);
        } 
    }
    echo json_encode($tutorialData);
?>