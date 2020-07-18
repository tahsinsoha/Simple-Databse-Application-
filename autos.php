<?php
require_once ('pdo.php');

if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
    die('Name parameter missing');
}
if (isset($_POST['logout'])) {
    header('Location: index.php');
    return;
}
if (empty($_POST['make'])) {
    echo ('<p style="color: red;">' . htmlentities("Make is required") . "</p>\n");
}
elseif (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['add'])) {

 if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) 
 echo ('<p style="color: red;">' . htmlentities("Mileage and year must be numeric") . "</p>\n");
 else {
        $sql = "INSERT INTO autos(make, year, mileage) 
              VALUES (:make, :year, :mileage)";
       // echo ("<pre>\n" . $sql . "\n</pre>\n");
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ));

        echo ('<p style="color: green;">' . htmlentities("Record inserted") . "</p>\n");
    }
    
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<title>Sabiha Tahsin Soha</title>

<head></head>
<?php
if (isset($_REQUEST['name'])) {
    echo "<h1>Tracking Autos for ";
    echo htmlentities($_REQUEST['name']);
    echo "</h1>\n";
}
?>

<body>
    <form method="post">
        <p>Make:
            <input type="text" name="make" size="40"></p>
        <p>Year:
            <input type="text" name="year"></p>
        <p>Mileage:
            <input type="text" name="mileage"></p>
        <p><input type="submit" value="Add"  name= "add"/>
            <input type="submit" value="Logout"  name="logout"/>
        </p>
      
    </form>

    <h2>Automobiles</h2>
    <ul>

        <?php
        foreach ($rows as $row) {
            echo '<li>';
            echo htmlentities($row['make']) . ' ' . $row['year'] . ' / ' . $row['mileage'];
        };
        echo '</li><br/>';
        ?>
    </ul>

</div>
</body>