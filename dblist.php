<?php
include_once 'php/core.php';
include_once 'php/db_core.php';
include_once 'php/multidb_core.php';

createHead('Your Reserved Users', 440, '<script src="js/unreserve.js" ></script>');

if (isset($_GET['gid'])) {
	$gid = (int) $_GET['gid'];
}

echo '<h2><a href=' . $_SERVER['PHP_SELF'] . '?gid=440>Your TF2 reserved users.</a></h2><br>';
echo '<h2><a href=' . $_SERVER['PHP_SELF'] . '?gid=730>Your CSGO reserved users.</a></h2><br>';

if (isset($gid) && is_numeric($_SESSION['sid']) && donator_level(20)) {

	switch ($_GET['gid']) {
		case 440:
			$collection = $c = db_init('items', 'unusual');
			include_once 'php/440_core.php';
			break;
		case 730:
			$collection = db_init('archive', 'items_730');
			include 'php/730_core.php';
			break;
	}

	$steamid = (int) $_SESSION['sid'];
	if (isset($_POST['notes'])) {
		$notes = (string) $_POST['notes'];
	} else {
		$notes = 'no notes.';
	}

	$cursor = $collection->find(array('user_reserver' => $steamid));
	if ($cursor->count() > 0) {
		echo '<input type="hidden" id=gameid value="' . $gid . '">';
		echo '<h3>These are your currently reserved users.</h3><br>';
		userlist_display($cursor, null, $gid);
	} else {
		echo '<h1>No currently reserved users</h1>';

	}
}

createFooter(440);
