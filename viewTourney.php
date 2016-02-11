<?php
$page_title = "Tourney details";
include_once 'include/header.php';

session_start();

// get ID of the tourney to view details
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'database/dbconfig.php';
include_once 'objects/tourney.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare tourney object
$tourney = new Tourney($db);
 
// set ID property of tourney
$tourney->id = $id;
 
// read the details of tourney
$tourney->readOne();

?>
	<h3>
		<?php echo "{$tourney->title}" ?>
	</h3>
	<div style="padding-bottom: 20px;">
		<span style="font-weight: bold;">Description</span>
		<div>
			<?php echo "{$tourney->description}" ?>	
		</div>
	</div>
	<?php 
		$stmt = $tourney->getAllParticipants();	
		$num = $stmt->rowCount();
	?>
	<div style="padding-bottom: 20px;">
		<span style="font-weight: bold;">Participants (<?=$num?> total):</span>
		<div>
		<?php
			if($num>0){
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					echo "{$name}<br/>";
				}
			}
		?>			
		</div>
	</div>
	<?php ?>
	<div style="padding-bottom: 20px;">
		<?php 	
			if(isset($_SESSION["errormsg"])) {
				$errorMsg = $_SESSION["errormsg"];
				session_unset($_SESSION["errormsg"]);
			} else {
				$errorMsg = "";
			}
			
			if(isset($_SESSION["successmsg"])) {
				$successMsg = $_SESSION["successmsg"];
				session_unset($_SESSION["successmsg"]);
			} else {
				$successMsg = "";
			}
			
		?>

		<div style="color: red;"><?=$errorMsg?></div>
		<div style="color: green;"><?=$successMsg?></div>
		<div style="font-weight: bold;">Registration</div>
		<div>
			Please press the button below to register.
			<form action="register.php" method="POST">
				<input type="submit" name="register" value="Register" />
				<input type="hidden" name="tourney_id" value="<?php echo "{$tourney->id}" ?>" />
			</form>
		</div>
	</div>
<?php
include_once 'include/footer.php';
?>