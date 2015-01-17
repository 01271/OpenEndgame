<?php
include 'db_core.php';
session_start();
if ((isset($_POST['reserve']) || isset($_POST['unreserve'])) && isset($_SESSION['sid']) && is_numeric($_SESSION['sid']) && isset($_POST['gid']) && is_numeric($_POST['gid']) && donator_level(20)) {
	switch ($_POST['gid']) {
		case 440:
			$collection = db_init('items', 'unusual');
			break;
		case 730:
			$collection = db_init('archive', 'items_730');
			break;

		default:
			echo 'User not reserved, this game is not supported.';
			return 0;
	}

	/*
	$m = new MongoClient();
	$db = $m->items;
	$collection = $db->unusual;
	 */

	$steamid = (int) $_SESSION['sid'];

	//user is reserving a database entry.
	if (isset($_POST['notes'])) {
		$notes = (string) $_POST['notes'];
	} else {
		$notes = 'no notes.';
	}

	$cursor = $collection->find(array('user_reserver' => $steamid));
	$resultCount = $cursor->count();
	$max = 5;
	if ((isset($_POST['reserve']) && !isset($_POST['unreserve'])) && isset($resultCount) && $resultCount >= $max) {
		echo
		"You cannot reserve more users.\nShark what you've already got then get some more!";
		die();
	}
	$gid = $_POST['gid'];
	if (isset($_POST['reserve'])) {
		if ($gid == 440)//fuck you too mongodb.
		{ $usr = (string) $_POST['reserve'];
		}

		if ($gid == 730)//fuck you too mongodb.
		{ $usr = (int) $_POST['reserve'];
		}

		$setunset = '$set';
	}

	if (isset($_POST['unreserve'])) {
		if ($gid == 440)//fuck you too mongodb.
		{ $usr = (string) $_POST['unreserve'];
		}

		if ($gid == 730)//fuck you too mongodb.
		{ $usr = (int) $_POST['unreserve'];
		}

		$setunset = '$unset';
	}

	$where = array('_id' => $usr);
	$data =
	array("$setunset"=> array(
			'user_reserver' => $steamid,
			'user_notes' => $notes,
			'date_reserved' => time()
		));
	$mongoptions = array('upsert' => false);
	$collection->update($where, $data, $mongoptions);
	//print_r( $db->lastError() );
	echo 'User ' . $usr . ' is now ' . ($setunset != '$set' ? 'unreserved.' : 'reserved.' . "\n" . 'Check your reserved users page to find them again.');
} else {
	echo 'Failed to reserve.';
	var_dump($_POST);
}
//$_POST['reserve'] this is the user to reserve's steamid.
//$_POST['notes'] these are the notes for the user.
//new mongo connection
//find where user_reserver is the session steamid.
//if they have more than 4 users reserved, do not let them reserve it.
//

//find where steamid = reserve
//insert into the user the current time and the user that reserved them

//date_reserved
//user_reserver
//user_notes

//when searching look for documents without date_reserved.

?>
