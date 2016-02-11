<?php
$page_title = "Tourney list";
include_once 'include/header.php';

// get database connection
include_once 'database/dbconfig.php';
include_once 'objects/tourney.php';


 
$database = new Database();
$db = $database->getConnection();

$tourney = new Tourney($db);

// query all tourneys
$stmt = $tourney->readAll();
$num = $stmt->rowCount();
// display the tourneys if there are any
if($num>0){
 
    //$category = new Category($db);
 
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Id</th>";
            echo "<th>Title</th>";
            echo "<th>Description</th>";
            echo "<th>Category</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td><a href=\"/tourney/viewTourney.php?id={$id}\">{$title}</a></td>";
                echo "<td>{$description}</td>";
                echo "<td>";
                echo "&nbsp;";
                echo "</td>";
 
                echo "<td>";
                    // edit and delete button will be here
                echo "</td>";
 
            echo "</tr>";
 
        }
 
    echo "</table>";
 
    // paging buttons will be here
}
 
// tell the user there are no tourneys
else{
    echo "<div>No tourneys found.</div>";
}


include_once 'include/footer.php';
?>