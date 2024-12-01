<?php
    include('config.php'); 
    $searchTerm = $_GET['term'];
    $sql = "SELECT * FROM angajati WHERE username LIKE '%".$searchTerm."%'"; 
    $result = $link->query($sql); 
    if ($result->num_rows > 0) {
        $tutorialData = array(); 
        while($row = $result->fetch_assoc()) {
            $data['id']    = $row['id']; 
            $data['value'] = $row['username'];
            array_push($tutorialData, $data);
        } 
    }
    echo json_encode($tutorialData);
?>