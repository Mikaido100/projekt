<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href="line.css">
</head>
<body>
    <?php

//połącz do bazy danych
$db = new mysqli("localhost","root", "", "zakupy");

if(isset($_REQUEST['newThing']) && $_REQUEST['newThing'] !="") {
    //wywoła się tylko jeśli wysłano przez post lub get cośpod indeksem"newThing"
    echo "dodaje pozycje";
    /*
    //bez prepared query
    $newThing = $_REQUEST['newThing'];
    $q = "INSERT INTO lista (ID, thing) VALUES(NULL, '$newThing')";
    $db->query($q);
    */
    //przy użyciu prepared query
$q = $db->prepare("INSERT INTO lista(ID, zakupy) VALUES(NULL, ?)");
$q->bind_param('s', $_REQUEST['newThing']);
$q->execute();
}
//usuwanie pozycji z listy
if(isset($_REQUEST['delete'])){
    echo "Usuwam pozycję";
    $q = $db->prepare("DELETE FROM lista WHERE id=?");
    $q->bind_param('i',$_REQUEST['delete']);
    $q->execute();
}
//zaznaczanie pozycji z listy
if(isset($_REQUEST['mark'])){
    echo "Skreślam pozycję";
    $q = $db->prepare("UPDATE lista SET complete = 1 WHERE id=?");
    $q->bind_param('i',$_REQUEST['mark']);
    $q->execute();
}
//przygotuj kwerendę
$q = "SELECT * FROM lista";

//wywołaj kwerendę i odbierz dane
$result = $db->query($q);

//wyciągnij jedną linię
//$row = $result->fetch_assoc();

//początek listy
echo '<ul>';
//wyciągaj po kolei jedną linie
while($row = $result->fetch_assoc()){
    //początek pozycji
    //sprawdź czy zaliczone
    if($row['complete']) {
        //pozycja zaliczona
        echo '<li class="complete">';

    } else {
        //pozycja niezaliczona
        echo '<li>';
    }
    //pozycja listy
    echo $row['zakupy'];
    //link do usunięcia
    echo '<a href="zakupy.php?delete='.$row['ID'].'">Usuń</a>';
    echo '<a href="zakupy.php?mark='.$row['ID'].'">Wykreśl</a>';
    //link do skreślania

    //koniec pozycji
    echo '</li>';
}
//koniec listy
echo '<ul>';

//debug
//echo"<pre>";
//var_dump($_REQUEST);

?>
<form action="zakupy.php" method="get">
    <label for="newThingInput"></label>
    <input type="text" name="newThing" id="newThingInpout">
    <input type="submit" value="Dodaj do listy">
    <?php
    echo"<pre>";
    var_dump($_REQUEST);
    ?>
</form>
</body>
</html>
