<?php
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'database/dbconfig.php';
	include_once 'objects/tourney.php';
    include_once 'objects/participant.php';
	
	session_start();
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

	$tourney_id = $_POST['tourney_id'];
 //echo $tourney_id;
 
    // prepare participant object
    $participant = new Participant($db);
     
    // set product id to be deleted
    $participant->name = "bzz86";//that will be username from session
    $participant->type = 1; 
	
	// TODO check if already exists in database
	if($participant->create()){
			

		//registration
		if($participant->assignToTourney($tourney_id)){
			$_SESSION["successmsg"]="You've been registered successfully!";
		}
		// if unable to assign to the tourney
		else{
			$_SESSION["errormsg"]="Problems with registration";
		}
	}else{
		$_SESSION["errormsg"]="Problems with participant creation";
	}	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}else{
	header("Location:index.php");
}
?>