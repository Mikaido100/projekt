<?php


$db = new mysqli("localhost", "root", "", "med");

$q =$db->prepare("SELECT * FROM staff" );


if($q->execute()) {

    $result =$q->get_result();
    while($row =$result->fetch_assoc()) {
        $firstname = $row['first name'];
        $lastname = $row["last name"];
        echo "lekarz $firstname $lastname<br>";
    }
} else {
    echo "błąd podczas wyszukiwania w bazie danych";
}



 
?>